<?php

namespace Database\Seeders;

use App\Models\Secteur;
use Illuminate\Database\Seeder;

class SecteurSeeder extends Seeder
{
    public function run(): void
    {
        $secteurs = [
            'Agriculture',
            'Artisanat',
            'Assainissement et Salubrité',
            'Commerce',
            'Culture',
            'Défense et Sécurité',
            'Emploi et Protection Sociale',
            'Enseignement Supérieur et Recherche Scientifique',
            'Enseignement Technique et Formation Professionnelle',
            'Environnement',
            'Femme, Famille et Enfant',
            'Genre et Égalité des Sexes',
            'Gouvernance Locale',
            'Habitat et Logement',
            'Hydraulique',
            'Industrie',
            'Infrastructures',
            'Infrastructures Routières',
            'Jeunesse',
            'Justice et Droits de l\'Homme',
            'Mines',
            'Promotion des PME',
            'Protection Civile',
            'Ressources Animales et Halieutiques',
            'Santé',
            'Sport',
            'Tourisme et Loisirs',
            'Transition Numérique',
            'Transport',
            'Éducation',
            'Électricité',
        ];

        foreach ($secteurs as $libelle) {
            Secteur::firstOrCreate(['libelle' => $libelle]);
        }
    }
}
