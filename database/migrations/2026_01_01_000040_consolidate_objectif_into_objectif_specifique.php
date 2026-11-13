<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// Le cahier des charges (51 entités) ne connaît que l'entité OBJECTIF_SPECIFIQUE
// ("id, libéllé, description", RG38 : rattachée à un seul projet) et relie directement
// RESULTAT_ATTENDU à OBJECTIF_SPECIFIQUE (RG30/RG31), sans entité OBJECTIF ni TYPE_OBJECTIF
// intermédiaire. Cette migration fusionne les anciennes tables 'objectifs' et 'types_objectif'
// dans 'objectifs_specifiques'.
return new class extends Migration {
    public function up(): void {
        Schema::table('objectifs_specifiques', function (Blueprint $table) {
            $table->text('description')->nullable()->after('libelle');
        });

        Schema::table('resultats_attendus', function (Blueprint $table) {
            $table->foreignId('objectif_specifique_id')->nullable()->after('objectif_id')
                ->constrained('objectifs_specifiques')->cascadeOnDelete();
        });

        if (Schema::hasTable('objectifs')) {
            // Reporte chaque "objectif" existant vers un objectif spécifique équivalent
            // (créé si besoin) afin de ne pas perdre les résultats attendus déjà saisis.
            DB::table('objectifs')->orderBy('id')->each(function ($objectif) {
                $newId = DB::table('objectifs_specifiques')->insertGetId([
                    'libelle' => $objectif->libelle,
                    'description' => $objectif->description ?? null,
                    'projet_id' => $objectif->projet_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                DB::table('resultats_attendus')->where('objectif_id', $objectif->id)
                    ->update(['objectif_specifique_id' => $newId]);
            });
        }

        Schema::table('resultats_attendus', function (Blueprint $table) {
            $table->dropConstrainedForeignId('objectif_id');
        });

        Schema::dropIfExists('objectifs');
        Schema::dropIfExists('types_objectif');
    }

    public function down(): void {
        Schema::create('types_objectif', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->timestamps();
        });

        Schema::create('objectifs', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->text('description')->nullable();
            $table->foreignId('type_objectif_id')->nullable()->constrained('types_objectif')->nullOnDelete();
            $table->foreignId('projet_id')->constrained('projets')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::table('resultats_attendus', function (Blueprint $table) {
            $table->foreignId('objectif_id')->nullable()->constrained('objectifs')->cascadeOnDelete();
        });

        Schema::table('resultats_attendus', function (Blueprint $table) {
            $table->dropConstrainedForeignId('objectif_specifique_id');
        });

        Schema::table('objectifs_specifiques', function (Blueprint $table) {
            $table->dropColumn('description');
        });
    }
};
