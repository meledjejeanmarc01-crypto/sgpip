<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('exercice');
            $table->decimal('credit_budgetaire_notifie', 18, 2)->nullable();
            $table->decimal('montant_pec_avant_exercice', 18, 2)->nullable();
            $table->decimal('montant_previsionnel_n', 18, 2)->nullable();
            $table->decimal('montant_previsionnel_n1', 18, 2)->nullable();
            $table->decimal('montant_previsionnel_n2', 18, 2)->nullable();
            $table->decimal('taux_execution_financier', 5, 2)->nullable();
            $table->decimal('taux_execution_physique', 5, 2)->nullable();
            $table->text('observation')->nullable();
            $table->foreignId('projet_id')->constrained('projets')->cascadeOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('budgets');
    }
};
