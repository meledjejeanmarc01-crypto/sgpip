<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// PAYS_ETRANGER — RG48 : un pays étranger peut correspondre à plusieurs zones d'exécution
// hors Côte d'Ivoire ; une zone d'exécution "Hors CI" appartient à un seul pays étranger.
return new class extends Migration {
    public function up(): void {
        Schema::create('pays_etrangers', function (Blueprint $table) {
            $table->id();
            $table->string('libelle')->unique();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('pays_etrangers');
    }
};
