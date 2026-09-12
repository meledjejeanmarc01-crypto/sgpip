<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('conventions_financement', function (Blueprint $table) {
            $table->id();
            $table->string('type_accord')->nullable();
            $table->string('nature_financement')->nullable();
            $table->date('date_limite_tirage')->nullable();
            $table->string('niveau_avancement_negociations')->nullable();
            $table->string('numero_accord_signe')->nullable();
            $table->decimal('montant', 18, 2)->nullable();
            $table->date('date_signature')->nullable();
            $table->foreignId('financement_id')->unique()->constrained('financements')->cascadeOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('conventions_financement');
    }
};
