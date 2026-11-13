<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

// Supprime les six anciennes tables, remplacées par "localisations" + "niveau_localisations".
// Les données ont été reprises par la migration précédente (000048).
// Si tu veux garder les anciennes tables quelque temps par précaution, supprime ce fichier
// avant de lancer "php artisan migrate" (tu pourras le remettre plus tard).
return new class extends Migration {
    public function up(): void {
        Schema::dropIfExists('villages');
        Schema::dropIfExists('sous_prefectures');
        Schema::dropIfExists('communes');
        Schema::dropIfExists('departements');
        Schema::dropIfExists('regions');
        Schema::dropIfExists('districts');
    }

    public function down(): void {
        // Les anciennes tables ne sont pas recréées : voir la migration 000034 si besoin.
    }
};
