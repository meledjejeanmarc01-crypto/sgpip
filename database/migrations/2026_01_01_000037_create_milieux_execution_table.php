<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// MILIEU D'EXECUTION — RG37 : "Un projet peut avoir plusieurs milieux d'exécutions.
// Un milieu d'execution peut être rattaché à un seul projet." => Milieu belongsTo Projet.
return new class extends Migration {
    public function up(): void {
        Schema::create('milieux_execution', function (Blueprint $table) {
            $table->id();
            $table->enum('categorie', ['rural', 'urbain', 'peri_urbain', 'inter_urbain']);
            $table->foreignId('projet_id')->constrained('projets')->cascadeOnDelete();
            $table->timestamps();
        });

        if (Schema::hasColumn('projets', 'milieu_execution')) {
            DB::table('projets')->whereNotNull('milieu_execution')->orderBy('id')
                ->each(function ($projet) {
                    DB::table('milieux_execution')->insert([
                        'categorie' => $projet->milieu_execution,
                        'projet_id' => $projet->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                });

            Schema::table('projets', function (Blueprint $table) {
                $table->dropColumn('milieu_execution');
            });
        }
    }

    public function down(): void {
        if (!Schema::hasColumn('projets', 'milieu_execution')) {
            Schema::table('projets', function (Blueprint $table) {
                $table->string('milieu_execution')->nullable();
            });
        }
        Schema::dropIfExists('milieux_execution');
    }
};
