<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('opportunites_emploi', function (Blueprint $table) {
            $table->id();
            $table->enum('type_emploi', ['direct', 'indirect']);
            $table->enum('phase', ['realisation', 'exploitation']);
            $table->unsignedInteger('nombre_emplois_prevus')->nullable();
            $table->unsignedInteger('duree_activite_previsionnelle')->nullable();
            $table->foreignId('projet_id')->constrained('projets')->cascadeOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('opportunites_emploi');
    }
};
