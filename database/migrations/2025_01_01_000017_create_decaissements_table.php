<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('decaissements', function (Blueprint $table) {
            $table->id();
            $table->decimal('montant', 18, 2);
            $table->date('date');
            $table->string('reference')->unique();
            $table->foreignId('bailleur_id')->constrained('bailleurs')->restrictOnDelete();
            $table->foreignId('financement_id')->nullable()->constrained('financements')->nullOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('decaissements');
    }
};
