<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('echeanciers_ae_cp', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('annee_lf');
            $table->decimal('montant_ae', 18, 2)->nullable();
            $table->decimal('montant_cp', 18, 2)->nullable();
            $table->foreignId('marche_id')->constrained('marches')->cascadeOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('echeanciers_ae_cp');
    }
};
