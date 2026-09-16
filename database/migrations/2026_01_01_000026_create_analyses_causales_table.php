<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('analyses_causales', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->foreignId('type_analyse_causale_id')->nullable()->constrained('types_analyse_causale')->nullOnDelete();
            $table->foreignId('projet_id')->constrained('projets')->cascadeOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('analyses_causales');
    }
};
