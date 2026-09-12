<?php

namespace Database\Seeders;

use App\Models\FichePip;
use App\Models\Programme;
use App\Models\Structure;
use Illuminate\Database\Seeder;

class ProgrammeFichePipSeeder extends Seeder
{
    public function run(): void
    {
        $mie = Structure::where('sigle', 'MIE')->first();
        $mena = Structure::where('sigle', 'MENA')->first();
        $sante = Structure::where('sigle', 'MSHPCMU')->first();

        $programme1 = Programme::firstOrCreate(
            ['code' => 'PROG-2026-001'],
            [
                'nom' => 'Programme National de Développement des Infrastructures et du Transport',
                'libelle' => 'PNDIT 2026-2030',
                'date_debut' => '2026-01-01',
                'date_fin' => '2030-12-31',
                'structure_id' => $mie->id,
            ]
        );

        $programme2 = Programme::firstOrCreate(
            ['code' => 'PROG-2026-002'],
            [
                'nom' => "Programme Régional de Renforcement de l'Offre Éducative",
                'libelle' => 'PRROE 2026-2028',
                'date_debut' => '2026-01-01',
                'date_fin' => '2028-12-31',
                'structure_id' => $mena->id,
            ]
        );

        $programme3 = Programme::firstOrCreate(
            ['code' => 'PROG-2026-003'],
            [
                'nom' => 'Programme de Couverture Sanitaire Universelle des Régions',
                'libelle' => 'PCSUR 2026-2029',
                'date_debut' => '2026-01-01',
                'date_fin' => '2029-12-31',
                'structure_id' => $sante->id,
            ]
        );

        FichePip::firstOrCreate(['numero' => 'PIP-2026-0001'], ['nom' => "Fiche d'identification - Infrastructures routières régionales", 'programme_id' => $programme1->id]);
        FichePip::firstOrCreate(['numero' => 'PIP-2026-0002'], ['nom' => "Fiche d'identification - Construction et réhabilitation d'écoles", 'programme_id' => $programme2->id]);
        FichePip::firstOrCreate(['numero' => 'PIP-2026-0003'], ['nom' => "Fiche d'identification - Établissements sanitaires de proximité", 'programme_id' => $programme3->id]);
    }
}
