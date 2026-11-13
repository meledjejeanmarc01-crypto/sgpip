<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Feuille PLANIFICATION du canevas : compléments des sections 1 à 7.
return new class extends Migration
{
    public function up(): void
    {
        // 1. Tranche de financement : code du bailleur/guichet, montant en devise, bénéficiaire, don, emprunt.
        Schema::table('financements', function (Blueprint $t) {
            if (! Schema::hasColumn('financements', 'code_guichet')) { $t->string('code_guichet', 50)->nullable(); }
            if (! Schema::hasColumn('financements', 'montant_devise')) { $t->decimal('montant_devise', 18, 2)->nullable(); }
            if (! Schema::hasColumn('financements', 'beneficiaire')) { $t->string('beneficiaire')->nullable(); }
            if (! Schema::hasColumn('financements', 'montant_don')) { $t->decimal('montant_don', 18, 2)->nullable(); }
            if (! Schema::hasColumn('financements', 'montant_emprunt')) { $t->decimal('montant_emprunt', 18, 2)->nullable(); }
        });

        // 3. Convention de financement : engagement contractuel, date des négociations, prorogation.
        Schema::table('conventions_financement', function (Blueprint $t) {
            if (! Schema::hasColumn('conventions_financement', 'engagement_contractuel')) { $t->boolean('engagement_contractuel')->nullable(); }
            if (! Schema::hasColumn('conventions_financement', 'date_avancement_negociations')) { $t->date('date_avancement_negociations')->nullable(); }
            if (! Schema::hasColumn('conventions_financement', 'proroge')) { $t->boolean('proroge')->nullable(); }
            if (! Schema::hasColumn('conventions_financement', 'duree_prorogation_mois')) { $t->unsignedSmallInteger('duree_prorogation_mois')->nullable(); }
        });

        // 2. Ventilation des coûts de financement interne.
        if (! Schema::hasTable('ventilations_financement_interne')) {
            Schema::create('ventilations_financement_interne', function (Blueprint $t) {
                $t->id();
                $t->foreignId('projet_id')->constrained('projets')->cascadeOnDelete();
                $t->string('source');
                $t->decimal('droits_taxes', 18, 2)->nullable();
                $t->decimal('hors_droits_taxes', 18, 2)->nullable();
                $t->decimal('numeraire_fuc', 18, 2)->nullable();
                $t->decimal('numeraire_par', 18, 2)->nullable();
                $t->decimal('numeraire_ao', 18, 2)->nullable();
                $t->decimal('nature_montant', 18, 2)->nullable();
                $t->string('nature_designation')->nullable();
                $t->text('observation')->nullable();
                $t->timestamps();
            });
        }

        // 4. Plan de décaissement : montant prévu par financement et par année.
        if (! Schema::hasTable('plans_decaissement')) {
            Schema::create('plans_decaissement', function (Blueprint $t) {
                $t->id();
                $t->foreignId('financement_id')->constrained('financements')->cascadeOnDelete();
                $t->unsignedSmallInteger('annee');
                $t->decimal('montant', 18, 2)->default(0);
                $t->timestamps();
            });
        }

        // 5. Plan de mise en œuvre global : début et fin prévisionnels (année + semestre) par composante.
        if (! Schema::hasTable('plans_mise_en_oeuvre_global')) {
            Schema::create('plans_mise_en_oeuvre_global', function (Blueprint $t) {
                $t->id();
                $t->foreignId('composante_id')->constrained('composantes')->cascadeOnDelete();
                $t->unsignedSmallInteger('annee_debut');
                $t->unsignedTinyInteger('semestre_debut');
                $t->unsignedSmallInteger('annee_fin');
                $t->unsignedTinyInteger('semestre_fin');
                $t->timestamps();
            });
        }

        // 6. Plan de mise en œuvre détaillé : montant prévisionnel par activité et par année.
        if (! Schema::hasTable('plans_mise_en_oeuvre_detaille')) {
            Schema::create('plans_mise_en_oeuvre_detaille', function (Blueprint $t) {
                $t->id();
                $t->foreignId('activite_id')->constrained('activites')->cascadeOnDelete();
                $t->unsignedSmallInteger('annee');
                $t->decimal('montant', 18, 2)->default(0);
                $t->timestamps();
            });
        }

        // 7. Plan de travail budgétisé annuel.
        if (! Schema::hasTable('plans_travail_annuel')) {
            Schema::create('plans_travail_annuel', function (Blueprint $t) {
                $t->id();
                $t->foreignId('activite_id')->constrained('activites')->cascadeOnDelete();
                $t->unsignedSmallInteger('exercice');
                $t->decimal('credit_budgetaire', 18, 2)->nullable();
                $t->unsignedSmallInteger('duree_mois')->nullable();
                $t->string('indicateur_libelle')->nullable();
                $t->decimal('cible', 18, 2)->nullable();
                $t->string('structure_responsable')->nullable();
                $t->decimal('t1', 5, 2)->nullable();
                $t->decimal('t2', 5, 2)->nullable();
                $t->decimal('t3', 5, 2)->nullable();
                $t->decimal('t4', 5, 2)->nullable();
                $t->timestamps();
            });
        }
    }

    public function down(): void
    {
        foreach (['plans_travail_annuel', 'plans_mise_en_oeuvre_detaille', 'plans_mise_en_oeuvre_global', 'plans_decaissement', 'ventilations_financement_interne'] as $table) {
            Schema::dropIfExists($table);
        }
        Schema::table('conventions_financement', function (Blueprint $t) {
            foreach (['engagement_contractuel', 'date_avancement_negociations', 'proroge', 'duree_prorogation_mois'] as $c) {
                if (Schema::hasColumn('conventions_financement', $c)) { $t->dropColumn($c); }
            }
        });
        Schema::table('financements', function (Blueprint $t) {
            foreach (['code_guichet', 'montant_devise', 'beneficiaire', 'montant_don', 'montant_emprunt'] as $c) {
                if (Schema::hasColumn('financements', $c)) { $t->dropColumn($c); }
            }
        });
    }
};
