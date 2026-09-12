<?php

namespace Database\Seeders;

use App\Models\TypeStructure;
use Illuminate\Database\Seeder;

class TypeStructureSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Ministère', 'Direction générale', 'Direction centrale', 'Établissement public', 'Collectivité territoriale'] as $libelle) {
            TypeStructure::firstOrCreate(['libelle' => $libelle]);
        }
    }
}
