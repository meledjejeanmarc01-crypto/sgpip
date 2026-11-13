<?php

namespace Database\Seeders;

use App\Models\NiveauLocalisation;
use Illuminate\Database\Seeder;

// Les 6 niveaux de la hiérarchie géographique (ids fixes : 1 = le plus large, 6 = le plus fin).
class NiveauLocalisationSeeder extends Seeder
{
    public function run(): void
    {
        $niveaux = ['District', 'Région', 'Département', 'Commune', 'Sous-préfecture', 'Village'];

        foreach ($niveaux as $i => $libelle) {
            NiveauLocalisation::updateOrCreate(['id' => $i + 1], ['libelle' => $libelle]);
        }
    }
}
