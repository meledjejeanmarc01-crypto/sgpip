<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('taches', function (Blueprint $table) {
            $table->id();
            $table->string('intitule');
            $table->text('description')->nullable();
            $table->date('date_debut')->nullable();
            $table->date('date_fin')->nullable();
            $table->foreignId('activite_id')->constrained('activites')->cascadeOnDelete();
            $table->foreignId('depense_id')->nullable()->constrained('depenses')->nullOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('taches');
    }
};
