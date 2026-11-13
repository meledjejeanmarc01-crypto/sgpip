<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

// LOCALISATION — cahier : "id, libellé, code, niveau_id, district_id, region_id,
// departement_id, commune_id, sous_prefecture_id".
// Une seule table porte toute la hiérarchie District > Région > Département > Commune
// > Sous-préfecture > Village. Au lieu d'un parent_id générique, chaque ligne porte
// directement une colonne par niveau d'ancêtre (RG43 à RG45) : par exemple une commune
// a directement son departement_id, region_id et district_id renseignés.
class Localisation extends Model
{
    protected $table = 'localisations';

    protected $fillable = [
        'libelle', 'code', 'description', 'latitude', 'longitude', 'niveau_id', 'milieu', 'localisation_parent_id',
        'district_id', 'region_id', 'departement_id', 'commune_id', 'sous_prefecture_id',
    ];

    public function localisationParent()
    {
        return $this->belongsTo(self::class, 'localisation_parent_id');
    }

    protected $casts = [
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
    ];

    /** Colonne d'ancêtre correspondant à un niveau (1=District ... 5=Sous-préfecture). */
    private const COLONNE_PAR_NIVEAU = [
        NiveauLocalisation::DISTRICT => 'district_id',
        NiveauLocalisation::REGION => 'region_id',
        NiveauLocalisation::DEPARTEMENT => 'departement_id',
        NiveauLocalisation::COMMUNE => 'commune_id',
        NiveauLocalisation::SOUS_PREFECTURE => 'sous_prefecture_id',
    ];

    /** Colonne d'ancêtre correspondant à un niveau (1=District ... 5=Sous-préfecture), ou null. */
    public static function niveauVersColonne(int $niveauId): ?string
    {
        return self::COLONNE_PAR_NIVEAU[$niveauId] ?? null;
    }

    // RG43 : une localisation appartient à un seul niveau.
    public function niveau(): BelongsTo
    {
        return $this->belongsTo(NiveauLocalisation::class, 'niveau_id');
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(self::class, 'district_id');
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(self::class, 'region_id');
    }

    public function departement(): BelongsTo
    {
        return $this->belongsTo(self::class, 'departement_id');
    }

    public function commune(): BelongsTo
    {
        return $this->belongsTo(self::class, 'commune_id');
    }

    public function sousPrefecture(): BelongsTo
    {
        return $this->belongsTo(self::class, 'sous_prefecture_id');
    }

    // RG42 : une localisation correspond à au plus une zone d'exécution.
    public function zoneExecution(): HasOne
    {
        return $this->hasOne(ZoneLocalisation::class, 'localisation_id');
    }

    /**
     * Ancêtre immédiat (RG44/RG45) : le district n'en a pas ; les autres niveaux
     * ont pour ancêtre immédiat la colonne du niveau juste au-dessus.
     */
    public function getParentImmediatAttribute(): ?self
    {
        return match ((int) $this->niveau_id) {
            NiveauLocalisation::REGION => $this->district,
            NiveauLocalisation::DEPARTEMENT => $this->region,
            NiveauLocalisation::COMMUNE => $this->departement,
            NiveauLocalisation::SOUS_PREFECTURE => $this->commune,
            NiveauLocalisation::VILLAGE => $this->sousPrefecture,
            default => null,
        };
    }

    /** Chemin complet, ex. : District des Savanes > Région du Poro > Département de Korhogo */
    public function getCheminAttribute(): string
    {
        $parties = array_filter([
            $this->district?->libelle,
            $this->region?->libelle,
            $this->departement?->libelle,
            $this->commune?->libelle,
            $this->sousPrefecture?->libelle,
            $this->libelle,
        ]);

        return implode(' > ', $parties);
    }

    /**
     * Coordonnées à utiliser pour la carte : celles de la localisation elle-même,
     * sinon celles de l'ancêtre le plus proche qui en a (ex. une commune sans
     * coordonnées utilise celles de son département). Null si aucune n'est trouvée.
     */
    public function getCoordonneesAttribute(): ?array
    {
        if ($this->latitude !== null && $this->longitude !== null) {
            return [(float) $this->latitude, (float) $this->longitude];
        }

        // Du plus proche au plus éloigné : sous-préfecture, commune, département, région, district.
        foreach ([$this->sousPrefecture, $this->commune, $this->departement, $this->region, $this->district] as $ancetre) {
            if ($ancetre && $ancetre->latitude !== null && $ancetre->longitude !== null) {
                return [(float) $ancetre->latitude, (float) $ancetre->longitude];
            }
        }

        return null;
    }

    /**
     * RG47 : une localisation qui a des localisations enfants ne peut pas être supprimée.
     * Un village est toujours une feuille (aucun niveau en dessous).
     */
    public function aDesEnfants(): bool
    {
        $colonne = self::COLONNE_PAR_NIVEAU[(int) $this->niveau_id] ?? null;

        return $colonne && self::where($colonne, $this->id)->exists();
    }

    /**
     * Nombre de localisations directement rattachées à celle-ci, c'est-à-dire
     * celles du niveau immédiatement inférieur (et non toutes les descendantes).
     */
    public function nombreEnfants(): int
    {
        $colonne = self::COLONNE_PAR_NIVEAU[(int) $this->niveau_id] ?? null;

        return $colonne
            ? self::where($colonne, $this->id)->where('niveau_id', (int) $this->niveau_id + 1)->count()
            : 0;
    }

    /**
     * Crée une localisation de niveau $niveauId sous l'ancêtre immédiat $parent
     * (null uniquement pour un District), en reconstituant automatiquement les
     * colonnes d'ancêtres (district_id, region_id, ...) à partir de celles du parent.
     */
    public static function creerSous(int $niveauId, ?self $parent, array $attributs): self
    {
        $ancetres = [
            'district_id' => null, 'region_id' => null, 'departement_id' => null,
            'commune_id' => null, 'sous_prefecture_id' => null,
        ];

        if ($parent) {
            // On repart des ancêtres du parent, puis on ajoute le parent lui-même
            // dans la colonne correspondant à son propre niveau.
            foreach ($ancetres as $colonne => $_) {
                $ancetres[$colonne] = $parent->{$colonne};
            }
            $colonneDuParent = self::COLONNE_PAR_NIVEAU[(int) $parent->niveau_id] ?? null;
            if ($colonneDuParent) {
                $ancetres[$colonneDuParent] = $parent->id;
            }
        }

        return self::create(array_merge($attributs, $ancetres, ['niveau_id' => $niveauId]));
    }
}
