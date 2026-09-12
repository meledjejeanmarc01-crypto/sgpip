<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('marches', function (Blueprint $table) {
            $table->id();
            $table->string('objet');
            $table->string('etat')->nullable();
            $table->string('duree')->nullable();
            $table->decimal('cout', 18, 2)->nullable();
            $table->decimal('montant_engage', 18, 2)->default(0);
            $table->decimal('montant_liquide', 18, 2)->default(0);
            $table->decimal('montant_paye', 18, 2)->default(0);
            $table->foreignId('projet_id')->constrained('projets')->cascadeOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('marches');
    }
};
