<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// Reprend les données des six anciennes tables (districts, regions, departements, communes,
// sous_prefectures, villages) dans la table unique "localisations", en reconstituant pour
// chaque ligne ses colonnes d'ancêtres (district_id, region_id, departement_id, commune_id,
// sous_prefecture_id) à partir de celles de son ancien parent, puis rattache chaque zone
// d'exécution existante à la localisation qui porte le même libellé.
return new class extends Migration {
    public function up(): void {
        if (!Schema::hasTable('districts')) {
            return;
        }

        // Pour chaque niveau : sa table d'origine, la clé vers son ancien parent,
        // le niveau de ce parent, et la colonne d'ancêtre à remplir avec l'id du parent lui-même.
        $niveaux = [
            ['table' => 'districts',        'niveau' => 1, 'fk_parent' => null,                 'niveau_parent' => null, 'colonne_parent' => null],
            ['table' => 'regions',          'niveau' => 2, 'fk_parent' => 'district_id',        'niveau_parent' => 1,    'colonne_parent' => 'district_id'],
            ['table' => 'departements',     'niveau' => 3, 'fk_parent' => 'region_id',          'niveau_parent' => 2,    'colonne_parent' => 'region_id'],
            ['table' => 'communes',         'niveau' => 4, 'fk_parent' => 'departement_id',     'niveau_parent' => 3,    'colonne_parent' => 'departement_id'],
            ['table' => 'sous_prefectures', 'niveau' => 5, 'fk_parent' => 'commune_id',         'niveau_parent' => 4,    'colonne_parent' => 'commune_id'],
            ['table' => 'villages',         'niveau' => 6, 'fk_parent' => 'sous_prefecture_id', 'niveau_parent' => 5,    'colonne_parent' => 'sous_prefecture_id'],
        ];

        $correspondance = []; // [niveau][ancien id] => nouvel id
        $ancetresDe = [];     // [niveau][ancien id] => [district_id, region_id, departement_id, commune_id, sous_prefecture_id]
        $colonnesVides = ['district_id' => null, 'region_id' => null, 'departement_id' => null, 'commune_id' => null, 'sous_prefecture_id' => null];

        foreach ($niveaux as $n) {
            foreach (DB::table($n['table'])->orderBy('id')->get() as $ancien) {
                $ancetresParent = $n['fk_parent']
                    ? ($ancetresDe[$n['niveau_parent']][$ancien->{$n['fk_parent']}] ?? $colonnesVides)
                    : $colonnesVides;
                $idParentNouveau = $n['fk_parent']
                    ? ($correspondance[$n['niveau_parent']][$ancien->{$n['fk_parent']}] ?? null)
                    : null;

                $ancetres = $ancetresParent;
                if ($n['colonne_parent'] && $idParentNouveau) {
                    $ancetres[$n['colonne_parent']] = $idParentNouveau;
                }

                $nouvelId = DB::table('localisations')->insertGetId(array_merge($ancetres, [
                    'libelle' => $ancien->nom,
                    'description' => $ancien->description ?? null,
                    'latitude' => $ancien->latitude ?? null,
                    'longitude' => $ancien->longitude ?? null,
                    'niveau_id' => $n['niveau'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));

                $correspondance[$n['niveau']][$ancien->id] = $nouvelId;
                $ancetresDe[$n['niveau']][$ancien->id] = $ancetres;
            }
        }

        // Rattache chaque zone (en Côte d'Ivoire) à la localisation de même libellé, la plus haute
        // dans la hiérarchie d'abord, sans jamais réutiliser une localisation déjà prise (unicité RG42).
        $zones = DB::table('zones_localisation')
            ->whereNull('localisation_id')->whereNull('pays_etranger_id')->orderBy('id')->get();

        foreach ($zones as $zone) {
            $localisation = DB::table('localisations as l')
                ->leftJoin('zones_localisation as z', 'z.localisation_id', '=', 'l.id')
                ->whereNull('z.id')
                ->where('l.libelle', $zone->libelle)
                ->orderBy('l.niveau_id')
                ->select('l.id')
                ->first();

            if ($localisation) {
                DB::table('zones_localisation')->where('id', $zone->id)->update(['localisation_id' => $localisation->id]);
            }
        }
    }

    public function down(): void {
        // Reprise de données : pas de retour en arrière automatique.
    }
};
