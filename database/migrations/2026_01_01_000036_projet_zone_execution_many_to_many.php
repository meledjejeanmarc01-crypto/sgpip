<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// RG41 : "Un projet appartient à plusieurs zones d'execution. Une zone d'exécution peut
// accueillir plusieurs projets." => relation plusieurs-à-plusieurs, pas une simple clé étrangère.
return new class extends Migration {
    public function up(): void {
        Schema::create('projet_zone_execution', function (Blueprint $table) {
            $table->id();
            $table->foreignId('projet_id')->constrained('projets')->cascadeOnDelete();
            $table->foreignId('zone_localisation_id')->constrained('zones_localisation')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['projet_id', 'zone_localisation_id'], 'projet_zone_unique');
        });

        if (Schema::hasColumn('projets', 'zone_localisation_id')) {
            // Reprend les rattachements existants dans la table pivot avant de supprimer la colonne.
            DB::table('projets')->whereNotNull('zone_localisation_id')->orderBy('id')
                ->each(function ($projet) {
                    DB::table('projet_zone_execution')->insert([
                        'projet_id' => $projet->id,
                        'zone_localisation_id' => $projet->zone_localisation_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                });

            Schema::table('projets', function (Blueprint $table) {
                $table->dropConstrainedForeignId('zone_localisation_id');
            });
        }
    }

    public function down(): void {
        if (!Schema::hasColumn('projets', 'zone_localisation_id')) {
            Schema::table('projets', function (Blueprint $table) {
                $table->foreignId('zone_localisation_id')->nullable()->constrained('zones_localisation')->nullOnDelete();
            });
        }
        Schema::dropIfExists('projet_zone_execution');
    }
};
