<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// NIVEAU_LOCALISATION — cahier : "id, libellé".
// Les 6 niveaux sont fixes ; l'id donne l'ordre hiérarchique (1 = le plus large, 6 = le plus fin).
// Ils sont insérés ici pour que la reprise des données (migration 000048) puisse s'appuyer dessus.
return new class extends Migration {
    public function up(): void {
        Schema::create('niveau_localisations', function (Blueprint $table) {
            $table->id();
            $table->string('libelle')->unique();
            $table->timestamps();
        });

        $niveaux = ['District', 'Région', 'Département', 'Commune', 'Sous-préfecture', 'Village'];
        foreach ($niveaux as $i => $libelle) {
            DB::table('niveau_localisations')->insert([
                'id' => $i + 1,
                'libelle' => $libelle,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void {
        Schema::dropIfExists('niveau_localisations');
    }
};
