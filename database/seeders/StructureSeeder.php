<?php

namespace Database\Seeders;

use App\Models\Structure;
use App\Models\TypeStructure;
use Illuminate\Database\Seeder;

class StructureSeeder extends Seeder
{
    public function run(): void
    {
        $ministere = TypeStructure::where('libelle', 'Ministère')->first();

        $structures = [
            ['libelle' => 'Ministère des Infrastructures Économiques', 'sigle' => 'MIE'],
            ['libelle' => 'Ministère des Transports', 'sigle' => 'MT'],
            ['libelle' => 'Ministère de la Transition Numérique et de la Digitalisation', 'sigle' => 'MTND'],
            ['libelle' => 'Ministère du Commerce, de l\'Industrie et de la Promotion des PME', 'sigle' => 'MCIPME'],
            ['libelle' => 'Ministère des Sports', 'sigle' => 'MSPT'],
            ['libelle' => 'Ministère de la Femme, de la Famille et de l\'Enfant', 'sigle' => 'MFFE'],
            ['libelle' => 'Ministère de la Justice et des Droits de l\'Homme', 'sigle' => 'MJDH'],
            ['libelle' => 'Ministère de l\'Hydraulique', 'sigle' => 'MH'],
            ['libelle' => 'Ministère de l\'Assainissement et de la Salubrité Urbaine', 'sigle' => 'MASU'],
            ['libelle' => 'Ministère de l\'Éducation Nationale et de l\'Alphabétisation', 'sigle' => 'MENA'],
            ['libelle' => 'Ministère de l\'Enseignement Supérieur et de la Recherche Scientifique', 'sigle' => 'MESRS'],
            ['libelle' => 'Ministère de l\'Enseignement Technique, de la Formation Professionnelle et de l\'Apprentissage', 'sigle' => 'METFPA'],
            ['libelle' => 'Ministère du Tourisme et des Loisirs', 'sigle' => 'MTL'],
            ['libelle' => 'Ministère de l\'Agriculture et du Développement Rural', 'sigle' => 'MADR'],
            ['libelle' => 'Ministère des Ressources Animales et Halieutiques', 'sigle' => 'MIRAH'],
            ['libelle' => 'Ministère de la Construction, du Logement et de l\'Urbanisme', 'sigle' => 'MCLU'],
            ['libelle' => 'Ministère de la Santé, de l\'Hygiène Publique et de la Couverture Maladie Universelle', 'sigle' => 'MSHPCMU'],
            ['libelle' => 'Ministère des Mines, du Pétrole et de l\'Énergie', 'sigle' => 'MMPE'],
            ['libelle' => 'Ministère de la Culture et de la Francophonie', 'sigle' => 'MCF'],
            ['libelle' => 'Ministère de l\'Administration du Territoire et de la Décentralisation', 'sigle' => 'MATD'],
            ['libelle' => 'Ministère de l\'Emploi et de la Protection Sociale', 'sigle' => 'MEPS'],
            ['libelle' => 'Ministère de la Défense', 'sigle' => 'MDEF'],
            ['libelle' => 'Ministère de l\'Intérieur et de la Sécurité', 'sigle' => 'MIS'],
            ['libelle' => 'Ministère de la Promotion de la Jeunesse', 'sigle' => 'MPJ'],
            ['libelle' => 'Ministère de l\'Environnement et du Développement Durable', 'sigle' => 'MINEDD'],
        ];

        foreach ($structures as $s) {
            Structure::firstOrCreate(
                ['sigle' => $s['sigle']],
                ['libelle' => $s['libelle'], 'type_structure_id' => $ministere->id]
            );
        }
    }
}
