<?php

namespace Database\Seeders;

use App\Models\TypeBailleur;
use Illuminate\Database\Seeder;

class TypeBailleurSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Institution multilatérale', 'Institution bilatérale', 'Banque de développement', 'ONG', 'Fonds public national'] as $libelle) {
            TypeBailleur::firstOrCreate(['libelle' => $libelle]);
        }
    }
}
