<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('financements', function (Blueprint $table) {
            $table->id();
            $table->decimal('montant_engage', 18, 2);
            $table->date('date');
            $table->string('reference')->unique();
            $table->foreignId('projet_id')->constrained('projets')->cascadeOnDelete();
            // Source du financement : un bailleur, ou l'Etat (acteur institutionnel - RG19)
            $table->foreignId('bailleur_id')->nullable()->constrained('bailleurs')->nullOnDelete();
            $table->foreignId('etat_id')->nullable()->constrained('etats')->nullOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('financements');
    }
};
