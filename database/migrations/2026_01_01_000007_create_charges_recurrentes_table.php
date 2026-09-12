<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('charges_recurrentes', function (Blueprint $table) {
            $table->id();
            $table->string('rubrique');
            $table->string('categorie')->nullable();
            $table->decimal('montant', 18, 2)->default(0);
            $table->unsignedSmallInteger('annee');
            $table->foreignId('projet_id')->constrained('projets')->cascadeOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('charges_recurrentes');
    }
};
