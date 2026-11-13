<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

// Renseigne les coordonnées (latitude/longitude) des localisations connues, pour que la
// carte du tableau de bord puisse placer un repère sur chaque zone d'exécution.
// Coordonnées approximatives des chefs-lieux/communes ; à ajuster si besoin depuis la page
// "Localisation géographique". Ce seeder est rejouable sans risque : il ne fait que
// compléter latitude/longitude sur les lignes existantes de "localisations", par libellé,
// sans rien créer ni supprimer (php artisan db:seed --class=LocalisationCoordinatesSeeder).
class LocalisationCoordinatesSeeder extends Seeder
{
    public function run(): void
    {
        $coordonnees = [
            // Districts / pôle Abidjan
            "District Autonome d'Abidjan" => [5.3600, -4.0083],
            'Abidjan' => [5.3600, -4.0083], // région et département portent le même libellé
            'District Autonome de Yamoussoukro' => [6.8276, -5.2893],
            'Yamoussoukro' => [6.8276, -5.2893],
            "Régions de l'intérieur" => [7.9000, -5.5000],

            // Communes du District d'Abidjan
            'Abobo' => [5.4181, -4.0156],
            'Adjamé' => [5.3667, -4.0247],
            'Attécoubé' => [5.3333, -4.0333],
            'Bingerville' => [5.3564, -3.8917],
            'Cocody' => [5.3600, -3.9800],
            'Koumassi' => [5.2989, -3.9581],
            'Marcory' => [5.2939, -3.9836],
            'Le Plateau' => [5.3200, -4.0200],
            'Port-Bouët' => [5.2500, -3.9333],
            'Songon' => [5.2500, -4.2667],
            'Treichville' => [5.2939, -4.0086],
            'Yopougon' => [5.3453, -4.0728],

            // Les 31 régions administratives (coordonnées de leur chef-lieu)
            'Agnéby-Tiassa' => [5.9297, -4.2178],
            'Bafing' => [8.2833, -7.6833],
            'Bagoué' => [9.5167, -6.4833],
            'Bélier' => [6.5667, -5.0167],
            'Béré' => [8.0500, -6.1833],
            'Bounkani' => [9.2667, -3.0000],
            'Cavally' => [6.5500, -7.4833],
            'Folon' => [10.0333, -7.6167],
            'Gbêkê' => [7.6906, -5.0300],
            'Gbôklé' => [4.9500, -6.0833],
            'Gôh' => [6.1319, -5.9506],
            'Gontougo' => [8.0402, -2.8000],
            'Grands-Ponts' => [5.3167, -4.3667],
            'Guémon' => [6.7500, -7.3500],
            'Hambol' => [8.1333, -5.1000],
            'Haut-Sassandra' => [6.8770, -6.4502],
            'Iffou' => [7.0575, -3.9636],
            'Indénié-Djuablin' => [6.7297, -3.4964],
            'Kabadougou' => [9.5045, -7.5657],
            'La Mé' => [6.1042, -3.8619],
            'Lôh-Djiboua' => [5.8383, -5.3572],
            'Marahoué' => [6.9967, -5.7433],
            'Moronou' => [6.6667, -4.2000],
            'Nawa' => [5.7847, -6.5936],
            'Nzi' => [6.6500, -4.7000],
            'Poro' => [9.4580, -5.6296],
            'San-Pédro' => [4.7485, -6.6363],
            'Sud-Comoé' => [5.4667, -3.2167],
            'Tchologo' => [9.5950, -5.1944],
            'Tonkpi' => [7.4125, -7.5539],
            'Worodougou' => [7.9611, -6.6731],
        ];

        foreach ($coordonnees as $libelle => [$lat, $lng]) {
            DB::table('localisations')
                ->where('libelle', $libelle)
                ->update(['latitude' => $lat, 'longitude' => $lng]);
        }
    }
}
