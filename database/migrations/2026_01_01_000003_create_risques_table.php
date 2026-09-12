<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('risques', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->text('consequence')->nullable();
            $table->enum('probabilite', ['faible', 'moyenne', 'forte'])->default('moyenne');
            $table->enum('criticite', ['faible', 'moyenne', 'elevee'])->default('moyenne');
            $table->text('mesure_mitigation')->nullable();
            $table->string('type_strategie')->nullable();
            $table->foreignId('projet_id')->constrained('projets')->cascadeOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('risques');
    }
};
