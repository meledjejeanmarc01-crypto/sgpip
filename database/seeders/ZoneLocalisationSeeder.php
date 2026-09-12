<?php

namespace Database\Seeders;

use App\Models\ZoneLocalisation;
use Illuminate\Database\Seeder;

class ZoneLocalisationSeeder extends Seeder
{
    public function run(): void
    {
        $zones = [
            ['libelle' => 'District Autonome d\'Abidjan', 'type' => 'district', 'parent' => null, 'latitude' => 5.36, 'longitude' => -4.0083],
            ['libelle' => 'District Autonome de Yamoussoukro', 'type' => 'district', 'parent' => null, 'latitude' => 6.8276, 'longitude' => -5.2893],
            ['libelle' => 'Abobo', 'type' => 'commune', 'parent' => 'District Autonome d\'Abidjan', 'latitude' => 5.4189, 'longitude' => -4.0159],
            ['libelle' => 'Adjamé', 'type' => 'commune', 'parent' => 'District Autonome d\'Abidjan', 'latitude' => 5.345, 'longitude' => -4.0208],
            ['libelle' => 'Attécoubé', 'type' => 'commune', 'parent' => 'District Autonome d\'Abidjan', 'latitude' => 5.335, 'longitude' => -4.04],
            ['libelle' => 'Bingerville', 'type' => 'commune', 'parent' => 'District Autonome d\'Abidjan', 'latitude' => 5.3559, 'longitude' => -3.8892],
            ['libelle' => 'Cocody', 'type' => 'commune', 'parent' => 'District Autonome d\'Abidjan', 'latitude' => 5.3599, 'longitude' => -3.9895],
            ['libelle' => 'Koumassi', 'type' => 'commune', 'parent' => 'District Autonome d\'Abidjan', 'latitude' => 5.2926, 'longitude' => -3.9528],
            ['libelle' => 'Marcory', 'type' => 'commune', 'parent' => 'District Autonome d\'Abidjan', 'latitude' => 5.2989, 'longitude' => -3.9847],
            ['libelle' => 'Le Plateau', 'type' => 'commune', 'parent' => 'District Autonome d\'Abidjan', 'latitude' => 5.32, 'longitude' => -4.017],
            ['libelle' => 'Port-Bouët', 'type' => 'commune', 'parent' => 'District Autonome d\'Abidjan', 'latitude' => 5.25, 'longitude' => -3.9333],
            ['libelle' => 'Songon', 'type' => 'commune', 'parent' => 'District Autonome d\'Abidjan', 'latitude' => 5.3167, 'longitude' => -4.2667],
            ['libelle' => 'Treichville', 'type' => 'commune', 'parent' => 'District Autonome d\'Abidjan', 'latitude' => 5.2926, 'longitude' => -4.0072],
            ['libelle' => 'Yopougon', 'type' => 'commune', 'parent' => 'District Autonome d\'Abidjan', 'latitude' => 5.3167, 'longitude' => -4.0833],
            ['libelle' => 'Agnéby-Tiassa', 'type' => 'region', 'parent' => null, 'latitude' => 5.9285, 'longitude' => -4.2151],
            ['libelle' => 'Bafing', 'type' => 'region', 'parent' => null, 'latitude' => 8.2833, 'longitude' => -7.6833],
            ['libelle' => 'Bagoué', 'type' => 'region', 'parent' => null, 'latitude' => 9.5241, 'longitude' => -6.4881],
            ['libelle' => 'Bélier', 'type' => 'region', 'parent' => null, 'latitude' => 6.5586, 'longitude' => -5.0169],
            ['libelle' => 'Béré', 'type' => 'region', 'parent' => null, 'latitude' => 8.0559, 'longitude' => -6.1892],
            ['libelle' => 'Bounkani', 'type' => 'region', 'parent' => null, 'latitude' => 9.2667, 'longitude' => -3.0],
            ['libelle' => 'Cavally', 'type' => 'region', 'parent' => null, 'latitude' => 6.5406, 'longitude' => -7.4867],
            ['libelle' => 'Folon', 'type' => 'region', 'parent' => null, 'latitude' => 10.3833, 'longitude' => -7.6167],
            ['libelle' => 'Gbêkê', 'type' => 'region', 'parent' => null, 'latitude' => 7.6939, 'longitude' => -5.03],
            ['libelle' => 'Gbôklé', 'type' => 'region', 'parent' => null, 'latitude' => 4.95, 'longitude' => -6.0833],
            ['libelle' => 'Gôh', 'type' => 'region', 'parent' => null, 'latitude' => 6.1319, 'longitude' => -5.9506],
            ['libelle' => 'Gontougo', 'type' => 'region', 'parent' => null, 'latitude' => 8.0402, 'longitude' => -2.8],
            ['libelle' => 'Grands-Ponts', 'type' => 'region', 'parent' => null, 'latitude' => 5.3167, 'longitude' => -4.3833],
            ['libelle' => 'Guémon', 'type' => 'region', 'parent' => null, 'latitude' => 6.75, 'longitude' => -7.35],
            ['libelle' => 'Hambol', 'type' => 'region', 'parent' => null, 'latitude' => 8.1333, 'longitude' => -5.1],
            ['libelle' => 'Haut-Sassandra', 'type' => 'region', 'parent' => null, 'latitude' => 6.877, 'longitude' => -6.4502],
            ['libelle' => 'Iffou', 'type' => 'region', 'parent' => null, 'latitude' => 7.0561, 'longitude' => -3.9647],
            ['libelle' => 'Indénié-Djuablin', 'type' => 'region', 'parent' => null, 'latitude' => 6.7297, 'longitude' => -3.4964],
            ['libelle' => 'Kabadougou', 'type' => 'region', 'parent' => null, 'latitude' => 9.5045, 'longitude' => -7.567],
            ['libelle' => 'La Mé', 'type' => 'region', 'parent' => null, 'latitude' => 6.105, 'longitude' => -3.8617],
            ['libelle' => 'Lôh-Djiboua', 'type' => 'region', 'parent' => null, 'latitude' => 5.8372, 'longitude' => -5.3572],
            ['libelle' => 'Marahoué', 'type' => 'region', 'parent' => null, 'latitude' => 6.9967, 'longitude' => -5.7461],
            ['libelle' => 'Moronou', 'type' => 'region', 'parent' => null, 'latitude' => 6.6667, 'longitude' => -4.2],
            ['libelle' => 'Nawa', 'type' => 'region', 'parent' => null, 'latitude' => 5.7847, 'longitude' => -6.5972],
            ['libelle' => 'Nzi', 'type' => 'region', 'parent' => null, 'latitude' => 6.6494, 'longitude' => -4.705],
            ['libelle' => 'Poro', 'type' => 'region', 'parent' => null, 'latitude' => 9.4578, 'longitude' => -5.6296],
            ['libelle' => 'San-Pédro', 'type' => 'region', 'parent' => null, 'latitude' => 4.7485, 'longitude' => -6.6363],
            ['libelle' => 'Sud-Comoé', 'type' => 'region', 'parent' => null, 'latitude' => 5.4703, 'longitude' => -3.2064],
            ['libelle' => 'Tchologo', 'type' => 'region', 'parent' => null, 'latitude' => 9.595, 'longitude' => -5.1944],
            ['libelle' => 'Tonkpi', 'type' => 'region', 'parent' => null, 'latitude' => 7.4125, 'longitude' => -7.5536],
            ['libelle' => 'Worodougou', 'type' => 'region', 'parent' => null, 'latitude' => 7.9614, 'longitude' => -6.6739],
        ];

        // Première passe : créer les districts et régions (sans parent)
        foreach ($zones as $z) {
            if ($z['parent'] === null) {
                ZoneLocalisation::firstOrCreate(
                    ['type' => $z['type'], 'libelle' => $z['libelle']],
                    ['latitude' => $z['latitude'], 'longitude' => $z['longitude']]
                );
            }
        }

        // Deuxième passe : créer les communes rattachées à leur district/région parent
        foreach ($zones as $z) {
            if ($z['parent'] !== null) {
                $parent = ZoneLocalisation::where('libelle', $z['parent'])->first();
                ZoneLocalisation::firstOrCreate(
                    ['type' => $z['type'], 'libelle' => $z['libelle']],
                    ['parent_id' => $parent?->id, 'latitude' => $z['latitude'], 'longitude' => $z['longitude']]
                );
            }
        }
    }
}
