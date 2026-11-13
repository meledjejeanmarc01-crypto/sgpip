<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

// Suppression définitive des modules hors cahier des charges : cibles (bénéficiaires), marchés et
// échéanciers AE/CP, charges récurrentes, budgets, portefeuilles, comités de projet,
// critères d'évaluation et opportunités d'emploi. Les données de ces tables sont perdues.
return new class extends Migration {
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        foreach ([
            'echeanciers_ae_cp',
            'marches',
            'charges_recurrentes',
            'budgets',
            'portefeuilles',
            'comites_projet',
            'criteres_evaluation',
            'opportunites_emploi',
            'cibles',
        ] as $table) {
            Schema::dropIfExists($table);
        }

        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        // Suppression irréversible : restaurer la base depuis la sauvegarde si nécessaire.
    }
};
