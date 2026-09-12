<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('fiche_pip_projet', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fiche_pip_id')->constrained('fiches_pip')->cascadeOnDelete();
            $table->foreignId('projet_id')->constrained('projets')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['fiche_pip_id', 'projet_id']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('fiche_pip_projet');
    }
};
