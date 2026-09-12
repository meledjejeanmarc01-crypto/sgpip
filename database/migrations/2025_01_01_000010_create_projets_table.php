<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('projets', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->string('intitule');
            $table->text('contexte')->nullable();
            $table->text('objectif')->nullable();
            $table->decimal('cout_estimatif', 18, 2)->default(0);
            $table->date('date_debut')->nullable();
            $table->date('date_fin')->nullable();
            $table->unsignedTinyInteger('avancement_physique')->default(0); // 0-100
            $table->enum('statut', ['planifie', 'en_cours', 'termine', 'suspendu', 'retarde'])->default('planifie');
            $table->foreignId('structure_id')->constrained('structures')->restrictOnDelete();
            $table->foreignId('secteur_id')->constrained('secteurs')->restrictOnDelete();
            $table->foreignId('zone_localisation_id')->constrained('zones_localisation')->restrictOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('projets');
    }
};
