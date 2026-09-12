<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('composantes', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->decimal('budget_previsionnel', 18, 2)->default(0);
            $table->foreignId('projet_id')->constrained('projets')->cascadeOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('composantes');
    }
};
