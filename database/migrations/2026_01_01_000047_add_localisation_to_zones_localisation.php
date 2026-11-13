<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// ZONE D'EXECUTION — cahier : "id, libellé, pays, description, statut, localisation_id".
// RG42 : une zone en Côte d'Ivoire est rattachée à une seule localisation (de n'importe quel niveau),
// et une localisation a au plus une zone (unique). Une zone hors CI n'a pas de localisation (null, RG48).
return new class extends Migration {
    public function up(): void {
        Schema::table('zones_localisation', function (Blueprint $table) {
            $table->text('description')->nullable();
            $table->string('statut')->default('actif');
            $table->foreignId('localisation_id')->nullable()->unique()
                ->constrained('localisations')->restrictOnDelete();
        });
    }

    public function down(): void {
        Schema::table('zones_localisation', function (Blueprint $table) {
            $table->dropConstrainedForeignId('localisation_id');
            $table->dropColumn(['description', 'statut']);
        });
    }
};
