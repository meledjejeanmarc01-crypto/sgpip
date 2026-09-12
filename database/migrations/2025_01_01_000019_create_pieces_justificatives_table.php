<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pieces_justificatives', function (Blueprint $table) {
            $table->id();
            $table->string('fichier');
            $table->enum('categorie', ['facture', 'recu', 'contrat', 'proces_verbal', 'autre'])->default('autre');
            $table->string('libelle')->nullable();
            $table->foreignId('projet_id')->constrained('projets')->cascadeOnDelete();
            $table->foreignId('utilisateur_id')->constrained('users')->restrictOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('pieces_justificatives');
    }
};
