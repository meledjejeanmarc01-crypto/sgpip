<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('resultats_attendus', function (Blueprint $table) {
            $table->id();
            $table->enum('niveau', ['impact', 'effet', 'extrant'])->default('extrant');
            $table->string('libelle');
            $table->string('situation_reference')->nullable();
            $table->string('cible')->nullable();
            $table->string('valeur_realisee')->nullable();
            $table->string('reste_a_atteindre')->nullable();
            $table->text('commentaire')->nullable();
            $table->foreignId('objectif_id')->constrained('objectifs')->cascadeOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('resultats_attendus');
    }
};
