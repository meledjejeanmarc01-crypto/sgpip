<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UtilisateurSeeder extends Seeder
{
    public function run(): void
    {
        $comptes = [
            ['nom' => 'Hien Toto', 'prenom' => 'I.', 'email' => 'i.hien@plan.gouv.ci', 'role' => 'administrateur'],
            ['nom' => 'Gbané', 'prenom' => 'I.', 'email' => 'i.gbane@plan.gouv.ci', 'role' => 'gestionnaire_projet'],
            ['nom' => 'Diarrassouba', 'prenom' => 'I.', 'email' => 'i.diarra@plan.gouv.ci', 'role' => 'responsable_financier'],
            ['nom' => 'Yapo', 'prenom' => 'I.', 'email' => 'i.yapo@plan.gouv.ci', 'role' => 'responsable_suivi_evaluation'],
            ['nom' => 'Bohoussou', 'prenom' => 'I.', 'email' => 'i.bohoussou@plan.gouv.ci', 'role' => 'consultant'],
        ];

        foreach ($comptes as $compte) {
            User::updateOrCreate(
                ['email' => $compte['email']],
                $compte + ['password' => Hash::make('Jeanmarc110'), 'actif' => true]
            );
        }
    }
}
