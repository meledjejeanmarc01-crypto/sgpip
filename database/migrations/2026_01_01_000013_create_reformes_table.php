<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('reformes', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->text('resultat_global_attendu')->nullable();
            $table->enum('statut', ['demarree', 'en_cours', 'achevee'])->default('demarree');
            $table->date('date_transmission_sgg')->nullable();
            $table->unsignedSmallInteger('annee_debut')->nullable();
            $table->unsignedSmallInteger('annee_fin')->nullable();
            $table->decimal('taux_execution_annee_precedente', 5, 2)->nullable();
            $table->decimal('taux_execution_previsionnel', 5, 2)->nullable();
            $table->string('cible_trimestre_1')->nullable();
            $table->string('cible_trimestre_2')->nullable();
            $table->string('cible_trimestre_3')->nullable();
            $table->string('cible_trimestre_4')->nullable();
            $table->string('localite')->nullable();
            $table->decimal('budget_global', 18, 2)->nullable();
            $table->string('source_financement')->nullable();
            $table->decimal('montant_etat', 18, 2)->nullable();
            $table->decimal('montant_autres_bailleurs', 18, 2)->nullable();
            $table->text('livrables_attendus')->nullable();
            $table->text('indicateurs')->nullable();
            $table->string('code_pjgouv')->nullable();
            $table->string('code_psgouv')->nullable();
            $table->text('observations')->nullable();
            $table->foreignId('structure_id')->constrained('structures')->restrictOnDelete();
            $table->foreignId('axe_id')->nullable()->constrained('axes')->nullOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('reformes');
    }
};
