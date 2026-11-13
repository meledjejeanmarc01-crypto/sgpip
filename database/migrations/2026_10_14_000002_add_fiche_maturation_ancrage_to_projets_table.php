<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Fiche de maturation, étape 2 : sections 5 à 12
// (programme/action budgétaire, portefeuille PND, ancrage stratégique, ODD, milieu et zone d'exécution).
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projets', function (Blueprint $table) {
            if (! Schema::hasColumn('projets', 'appartient_portefeuille_pnd')) {
                $table->boolean('appartient_portefeuille_pnd')->nullable();
            }
            if (! Schema::hasColumn('projets', 'portefeuille_pnd_projets')) {
                $table->text('portefeuille_pnd_projets')->nullable();
            }
            if (! Schema::hasColumn('projets', 'ancrage_document_source')) {
                $table->string('ancrage_document_source')->nullable();
            }
            if (! Schema::hasColumn('projets', 'ancrage_objectifs_strategies')) {
                $table->text('ancrage_objectifs_strategies')->nullable();
            }
        });

        // Ces deux champs reçoivent des textes longs dans le canevas (plusieurs programmes/actions, plusieurs ODD).
        Schema::table('projets', function (Blueprint $table) {
            $table->text('programme_budgetaire')->nullable()->change();
            $table->text('odd_concerne')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('projets', function (Blueprint $table) {
            foreach (['appartient_portefeuille_pnd', 'portefeuille_pnd_projets', 'ancrage_document_source', 'ancrage_objectifs_strategies'] as $c) {
                if (Schema::hasColumn('projets', $c)) {
                    $table->dropColumn($c);
                }
            }
        });
    }
};
