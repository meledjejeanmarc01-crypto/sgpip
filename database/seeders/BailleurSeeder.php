<?php

namespace Database\Seeders;

use App\Models\Bailleur;
use App\Models\TypeBailleur;
use Illuminate\Database\Seeder;

class BailleurSeeder extends Seeder
{
    public function run(): void
    {
        $multi = TypeBailleur::where('libelle', 'Institution multilatérale')->first();
        $banque = TypeBailleur::where('libelle', 'Banque de développement')->first();

        $bailleurs = [
            ['nom' => 'Banque Mondiale', 'sigle' => 'BM', 'type_bailleur_id' => $multi->id],
            ['nom' => 'Banque Africaine de Développement', 'sigle' => 'BAD', 'type_bailleur_id' => $banque->id],
            ['nom' => 'Agence Française de Développement', 'sigle' => 'AFD', 'type_bailleur_id' => $banque->id],
            ['nom' => 'Union Européenne', 'sigle' => 'UE', 'type_bailleur_id' => $multi->id],
        ];

        foreach ($bailleurs as $b) {
            Bailleur::firstOrCreate(['sigle' => $b['sigle']], $b);
        }
    }
}
