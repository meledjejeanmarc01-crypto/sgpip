<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('acteurs', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->string('role')->nullable();
            $table->foreignId('groupe_acteur_id')->nullable()->constrained('groupes_acteur')->nullOnDelete();
            $table->timestamps();
        });
        Schema::create('acteur_projet', function (Blueprint $table) {
            $table->id();
            $table->foreignId('acteur_id')->constrained('acteurs')->cascadeOnDelete();
            $table->foreignId('projet_id')->constrained('projets')->cascadeOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('acteur_projet');
        Schema::dropIfExists('acteurs');
    }
};
