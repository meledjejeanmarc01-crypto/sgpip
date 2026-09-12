<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('indicateurs', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('unite')->nullable();
            $table->decimal('valeur_cible', 18, 2)->nullable();
            $table->decimal('valeur_realisee', 18, 2)->nullable();
            $table->date('date_mesure')->nullable();
            $table->foreignId('activite_id')->constrained('activites')->cascadeOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('indicateurs');
    }
};
