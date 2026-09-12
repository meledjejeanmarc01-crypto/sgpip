<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('etats', function (Blueprint $table) {
            $table->id();
            $table->string('sigle');
            $table->string('libelle');
            $table->string('adresse')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('etats');
    }
};
