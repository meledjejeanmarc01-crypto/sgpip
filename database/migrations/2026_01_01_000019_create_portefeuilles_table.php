<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('portefeuilles', function (Blueprint $table) {
            $table->id();
            $table->boolean('appartenance_pnd')->default(false);
            $table->string('libelle_associe')->nullable();
            $table->foreignId('projet_id')->constrained('projets')->cascadeOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('portefeuilles');
    }
};
