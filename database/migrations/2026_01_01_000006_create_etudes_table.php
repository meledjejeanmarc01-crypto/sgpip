<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('etudes', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->string('mode_execution')->nullable();
            $table->string('structure_realisation')->nullable();
            $table->decimal('budget', 18, 2)->nullable();
            $table->date('date_demarrage')->nullable();
            $table->string('duree')->nullable();
            $table->string('etat_execution')->nullable();
            $table->foreignId('projet_id')->constrained('projets')->cascadeOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('etudes');
    }
};
