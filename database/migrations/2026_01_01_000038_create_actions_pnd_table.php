<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// ACTION_PND — RG40 : "Une Action peut concerner plusieurs Projets, un Projet n'est
// rattaché qu'à une seule Action." => Projet belongsTo ActionPnd.
return new class extends Migration {
    public function up(): void {
        Schema::create('actions_pnd', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::table('projets', function (Blueprint $table) {
            $table->foreignId('action_pnd_id')->nullable()->after('axe_id')
                ->constrained('actions_pnd')->nullOnDelete();
        });

        if (Schema::hasColumn('projets', 'action_pnd')) {
            DB::table('projets')->whereNotNull('action_pnd')->where('action_pnd', '!=', '')->orderBy('id')
                ->each(function ($projet) {
                    $actionId = DB::table('actions_pnd')->where('libelle', $projet->action_pnd)->value('id');
                    if (!$actionId) {
                        $actionId = DB::table('actions_pnd')->insertGetId([
                            'libelle' => $projet->action_pnd,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                    DB::table('projets')->where('id', $projet->id)->update(['action_pnd_id' => $actionId]);
                });

            Schema::table('projets', function (Blueprint $table) {
                $table->dropColumn('action_pnd');
            });
        }
    }

    public function down(): void {
        if (!Schema::hasColumn('projets', 'action_pnd')) {
            Schema::table('projets', function (Blueprint $table) {
                $table->string('action_pnd')->nullable();
            });
        }
        Schema::table('projets', function (Blueprint $table) {
            $table->dropConstrainedForeignId('action_pnd_id');
        });
        Schema::dropIfExists('actions_pnd');
    }
};
