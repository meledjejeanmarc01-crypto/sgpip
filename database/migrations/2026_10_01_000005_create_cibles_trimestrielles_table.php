<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// RG12 : un indicateur est détaillé en quatre cibles trimestrielles.
return new class extends Migration {
    public function up(): void
    {
        Schema::create('cibles_trimestrielles', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('trimestre'); // 1 à 4
            $table->decimal('valeur_cible', 18, 2)->default(0);
            $table->foreignId('indicateur_id')->constrained('indicateurs')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['indicateur_id', 'trimestre']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cibles_trimestrielles');
    }
};
