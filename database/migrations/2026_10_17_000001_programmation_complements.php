<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Feuille PROGRAMMATION du canevas : compléments des sections 1 à 4.
return new class extends Migration
{
    public function up(): void
    {
        // 1. Demande de financement de l'année de programmation.
        if (! Schema::hasTable('demandes_financement')) {
            Schema::create('demandes_financement', function (Blueprint $t) {
                $t->id();
                $t->foreignId('projet_id')->constrained('projets')->cascadeOnDelete();
                $t->unsignedSmallInteger('annee_base');
                $t->decimal('demande_globale_n1', 18, 2)->nullable();
                $t->timestamps();
            });
        }

        // 2. Échéancier des prévisions en valeur (projet exclusivement national ou cofinancé).
        if (! Schema::hasTable('previsions_valeur')) {
            Schema::create('previsions_valeur', function (Blueprint $t) {
                $t->id();
                $t->foreignId('projet_id')->constrained('projets')->cascadeOnDelete();
                $t->string('type_echeancier', 20)->default('exclusif');
                $t->string('nature', 5);
                $t->string('bailleur_guichet')->nullable();
                $t->string('rubrique', 30)->nullable();
                $t->unsignedSmallInteger('annee_base');
                $t->decimal('montant_total', 18, 2)->nullable();
                $t->decimal('pec_avant', 18, 2)->nullable();
                $t->decimal('pec_n3', 18, 2)->nullable();
                $t->decimal('pec_n2', 18, 2)->nullable();
                $t->decimal('pec_n1', 18, 2)->nullable();
                $t->decimal('credit_budgetaire_n', 18, 2)->nullable();
                $t->decimal('prevision_n1', 18, 2)->nullable();
                $t->decimal('prevision_n2', 18, 2)->nullable();
                $t->decimal('apres', 18, 2)->nullable();
                $t->timestamps();
            });
        }

        // 3. Programmation des activités à soumettre à la loi de finances.
        if (! Schema::hasTable('programmation_activites_lf')) {
            Schema::create('programmation_activites_lf', function (Blueprint $t) {
                $t->id();
                $t->foreignId('activite_id')->constrained('activites')->cascadeOnDelete();
                $t->unsignedSmallInteger('annee_base');
                $t->text('livrable')->nullable();
                $t->string('nature_economique_code', 20)->nullable();
                $t->string('nature_economique_libelle')->nullable();
                $t->string('type_financement')->nullable();
                $t->string('bailleur_guichet')->nullable();
                $t->decimal('cout_total', 18, 2)->nullable();
                $t->decimal('cumul_pec_avant', 18, 2)->nullable();
                $t->decimal('credit_budgetaire_n', 18, 2)->nullable();
                $t->decimal('prevision_n1', 18, 2)->nullable();
                $t->decimal('prevision_n2', 18, 2)->nullable();
                $t->decimal('prevision_n3', 18, 2)->nullable();
                $t->timestamps();
            });
        }

        // 4. Fiche AE-CP : engagements et liquidations antérieurs (i1, i2, j1, j2).
        Schema::table('marches', function (Blueprint $t) {
            foreach (['engagements_anterieurs_i1', 'engagements_anterieurs_i2', 'liquidations_j1', 'liquidations_j2'] as $c) {
                if (! Schema::hasColumn('marches', $c)) {
                    $t->decimal($c, 18, 2)->nullable();
                }
            }
        });
    }

    public function down(): void
    {
        foreach (['programmation_activites_lf', 'previsions_valeur', 'demandes_financement'] as $table) {
            Schema::dropIfExists($table);
        }
        Schema::table('marches', function (Blueprint $t) {
            foreach (['engagements_anterieurs_i1', 'engagements_anterieurs_i2', 'liquidations_j1', 'liquidations_j2'] as $c) {
                if (Schema::hasColumn('marches', $c)) {
                    $t->dropColumn($c);
                }
            }
        });
    }
};
