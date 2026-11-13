<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

// Cahier des charges §6 / §9.1 : trois rôles utilisateur (administrateur, gestionnaire de projet, consultant).
// Les comptes « responsable financier » et « responsable suivi-évaluation » deviennent gestionnaires de projet.
return new class extends Migration {
    public function up(): void
    {
        DB::table('users')
            ->whereIn('role', ['responsable_financier', 'responsable_suivi_evaluation'])
            ->update(['role' => 'gestionnaire_projet']);

        if (in_array(DB::getDriverName(), ['mysql', 'mariadb'], true)) {
            DB::statement("ALTER TABLE users MODIFY role ENUM('administrateur','gestionnaire_projet','consultant') NOT NULL DEFAULT 'consultant'");
        }
    }

    public function down(): void
    {
        if (in_array(DB::getDriverName(), ['mysql', 'mariadb'], true)) {
            DB::statement("ALTER TABLE users MODIFY role ENUM('administrateur','gestionnaire_projet','responsable_financier','responsable_suivi_evaluation','consultant') NOT NULL DEFAULT 'consultant'");
        }
    }
};
