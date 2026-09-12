<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('activites', function (Blueprint $table) {
            $table->id();
            $table->string('intitule');
            $table->date('date_debut')->nullable();
            $table->date('date_fin')->nullable();
            $table->unsignedTinyInteger('taux_avancement')->default(0);
            $table->foreignId('projet_id')->constrained('projets')->cascadeOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('activites');
    }
};
