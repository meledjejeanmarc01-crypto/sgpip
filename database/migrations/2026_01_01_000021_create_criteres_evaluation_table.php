<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('criteres_evaluation', function (Blueprint $table) {
            $table->id();
            $table->string('critere');
            $table->string('sous_critere')->nullable();
            $table->enum('appreciation', ['total', 'partiel', 'faible', 'oui', 'non'])->nullable();
            $table->text('justification')->nullable();
            $table->foreignId('projet_id')->constrained('projets')->cascadeOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('criteres_evaluation');
    }
};
