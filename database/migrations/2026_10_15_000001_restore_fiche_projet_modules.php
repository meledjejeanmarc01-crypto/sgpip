<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Rétablit les volets de la fiche projet exigés par le canevas du Ministère
// (supprimés par 2026_10_02_000001_drop_modules_hors_cahier) :
// bénéficiaires, emplois, comités et mécanismes de gestion, charges récurrentes,
// critères d'appréciation, budgets, marchés et échéancier AE-CP.
// Chaque création est ignorée si la table existe déjà.
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('cibles')) {
            Schema::create('cibles', function (Blueprint $t) {
                $t->id();
                $t->string('type_beneficiaire')->nullable();
                $t->string('groupe_acteur')->nullable();
                $t->string('acteur')->nullable();
                $t->text('probleme_specifique')->nullable();
                $t->text('attentes')->nullable();
                $t->text('craintes')->nullable();
                $t->string('taille')->nullable();
                $t->foreignId('projet_id')->constrained('projets')->cascadeOnDelete();
                $t->timestamps();
            });
        }
        if (! Schema::hasTable('opportunites_emploi')) {
            Schema::create('opportunites_emploi', function (Blueprint $t) {
                $t->id();
                $t->enum('type_emploi', ['direct', 'indirect']);
                $t->enum('phase', ['realisation', 'exploitation']);
                $t->unsignedInteger('nombre_emplois_prevus')->nullable();
                $t->unsignedInteger('duree_activite_previsionnelle')->nullable();
                $t->foreignId('projet_id')->constrained('projets')->cascadeOnDelete();
                $t->timestamps();
            });
        }
        if (! Schema::hasTable('comites_projet')) {
            Schema::create('comites_projet', function (Blueprint $t) {
                $t->id();
                $t->enum('type', ['supervision', 'pilotage', 'technique', 'suivi_evaluation', 'audit_controle']);
                $t->string('role')->nullable();
                $t->text('composition')->nullable();
                $t->text('observation')->nullable();
                $t->foreignId('projet_id')->constrained('projets')->cascadeOnDelete();
                $t->timestamps();
            });
        }
        if (! Schema::hasTable('charges_recurrentes')) {
            Schema::create('charges_recurrentes', function (Blueprint $t) {
                $t->id();
                $t->string('rubrique');
                $t->string('categorie')->nullable();
                $t->decimal('montant', 18, 2)->default(0);
                $t->unsignedSmallInteger('annee');
                $t->foreignId('projet_id')->constrained('projets')->cascadeOnDelete();
                $t->timestamps();
            });
        }
        if (! Schema::hasTable('criteres_evaluation')) {
            Schema::create('criteres_evaluation', function (Blueprint $t) {
                $t->id();
                $t->string('critere');
                $t->string('sous_critere')->nullable();
                $t->enum('appreciation', ['total', 'partiel', 'faible', 'oui', 'non'])->nullable();
                $t->text('justification')->nullable();
                $t->foreignId('projet_id')->constrained('projets')->cascadeOnDelete();
                $t->timestamps();
            });
        }
        if (! Schema::hasTable('budgets')) {
            Schema::create('budgets', function (Blueprint $t) {
                $t->id();
                $t->unsignedSmallInteger('exercice');
                $t->decimal('credit_budgetaire_notifie', 18, 2)->nullable();
                $t->decimal('montant_pec_avant_exercice', 18, 2)->nullable();
                $t->decimal('montant_previsionnel_n', 18, 2)->nullable();
                $t->decimal('montant_previsionnel_n1', 18, 2)->nullable();
                $t->decimal('montant_previsionnel_n2', 18, 2)->nullable();
                $t->decimal('taux_execution_financier', 5, 2)->nullable();
                $t->decimal('taux_execution_physique', 5, 2)->nullable();
                $t->text('observation')->nullable();
                $t->foreignId('projet_id')->constrained('projets')->cascadeOnDelete();
                $t->timestamps();
            });
        }
        if (! Schema::hasTable('marches')) {
            Schema::create('marches', function (Blueprint $t) {
                $t->id();
                $t->string('objet');
                $t->string('etat')->nullable();
                $t->string('duree')->nullable();
                $t->decimal('cout', 18, 2)->nullable();
                $t->decimal('montant_engage', 18, 2)->default(0);
                $t->decimal('montant_liquide', 18, 2)->default(0);
                $t->decimal('montant_paye', 18, 2)->default(0);
                $t->decimal('restes_a_engager', 18, 2)->nullable();
                $t->decimal('charges_a_payer', 18, 2)->nullable();
                $t->foreignId('projet_id')->constrained('projets')->cascadeOnDelete();
                $t->timestamps();
            });
        }
        if (! Schema::hasTable('echeanciers_ae_cp')) {
            Schema::create('echeanciers_ae_cp', function (Blueprint $t) {
                $t->id();
                $t->unsignedSmallInteger('annee_lf');
                $t->decimal('montant_ae', 18, 2)->nullable();
                $t->decimal('montant_cp', 18, 2)->nullable();
                $t->foreignId('marche_id')->constrained('marches')->cascadeOnDelete();
                $t->timestamps();
            });
        }

        // Compléments du « cadre de gestion » et des charges récurrentes (canevas, sections 25 et 30).
        Schema::table('projets', function (Blueprint $t) {
            if (! Schema::hasColumn('projets', 'partenaires_projet')) {
                $t->text('partenaires_projet')->nullable();
            }
            if (! Schema::hasColumn('projets', 'plan_implementation')) {
                $t->text('plan_implementation')->nullable();
            }
            if (! Schema::hasColumn('projets', 'charges_recurrentes_date_debut')) {
                $t->date('charges_recurrentes_date_debut')->nullable();
            }
            if (! Schema::hasColumn('projets', 'charges_recurrentes_duree')) {
                $t->string('charges_recurrentes_duree')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('projets', function (Blueprint $t) {
            foreach (['partenaires_projet', 'plan_implementation', 'charges_recurrentes_date_debut', 'charges_recurrentes_duree'] as $c) {
                if (Schema::hasColumn('projets', $c)) {
                    $t->dropColumn($c);
                }
            }
        });
        foreach (['echeanciers_ae_cp', 'marches', 'budgets', 'criteres_evaluation', 'charges_recurrentes', 'comites_projet', 'opportunites_emploi', 'cibles'] as $table) {
            Schema::dropIfExists($table);
        }
    }
};
