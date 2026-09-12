<?php

namespace Database\Seeders;

use App\Models\Etat;
use Illuminate\Database\Seeder;

class EtatSeeder extends Seeder
{
    public function run(): void
    {
        Etat::firstOrCreate(
            ['sigle' => 'CI'],
            ['libelle' => "État de Côte d'Ivoire", 'adresse' => 'Abidjan, Plateau']
        );
    }
}
