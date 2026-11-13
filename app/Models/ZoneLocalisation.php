<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

// ZONE D'EXECUTION — cahier : "id, libellé, pays, description, statut, localisation_id".
class ZoneLocalisation extends Model
{
    protected $table = 'zones_localisation';

    protected $fillable = [
        'libelle', 'pays', 'pays_etranger_id', 'description', 'statut', 'localisation_id', 'latitude', 'longitude',
    ];

    // RG48 : une zone d'exécution "Hors CI" appartient à un seul pays étranger.
    public function paysEtranger(): BelongsTo
    {
        return $this->belongsTo(PaysEtranger::class);
    }

    // RG42 : une zone en Côte d'Ivoire est rattachée à une seule localisation, de n'importe quel niveau.
    public function localisation(): BelongsTo
    {
        return $this->belongsTo(Localisation::class, 'localisation_id');
    }

    // RG41 : une zone d'exécution peut accueillir plusieurs projets (et réciproquement).
    public function projets(): BelongsToMany
    {
        return $this->belongsToMany(Projet::class, 'projet_zone_execution', 'zone_localisation_id', 'projet_id');
    }

    /**
     * Coordonnées à utiliser pour la carte : celles saisies directement sur la zone,
     * sinon celles de sa localisation (voir Localisation::coordonnees). Null pour une
     * zone hors Côte d'Ivoire sans coordonnées propres.
     */
    public function getCoordonneesAttribute(): ?array
    {
        if ($this->latitude !== null && $this->longitude !== null) {
            return [(float) $this->latitude, (float) $this->longitude];
        }

        return $this->localisation?->coordonnees;
    }
}
