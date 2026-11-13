<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// DOCUMENT — table manquante dans le projet d'origine (le modèle et le contrôleur
// existaient déjà, mais aucune migration ne créait la table). Champs de base ;
// la migration 000039 ajoute ensuite type_document_id, source et strategie.
return new class extends Migration {
    public function up(): void {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('projet_id')->constrained('projets')->cascadeOnDelete();
            $table->string('titre');
            $table->string('type')->nullable();
            $table->string('fichier');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('taille')->nullable();
            $table->string('extension', 20)->nullable();
            $table->foreignId('ajoute_par_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('documents');
    }
};
