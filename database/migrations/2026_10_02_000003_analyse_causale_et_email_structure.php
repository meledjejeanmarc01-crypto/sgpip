<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// ANALYSE CAUSALE (cahier §7) : problème identifié, cause, effet.
// STRUCTURE : adresse e-mail, pour notifier la structure de la décision sur ses projets (§9.4).
return new class extends Migration {
    public function up(): void
    {
        Schema::table('analyses_causales', function (Blueprint $table) {
            $table->text('probleme_identifie')->nullable()->after('libelle');
            $table->text('cause')->nullable()->after('probleme_identifie');
            $table->text('effet')->nullable()->after('cause');
        });

        // Reprise des lignes existantes : le libellé devient la cause (ou l'effet) selon son type, sinon le problème.
        $types = DB::table('types_analyse_causale')->pluck('libelle', 'id');
        foreach (DB::table('analyses_causales')->get() as $ligne) {
            $type = mb_strtolower((string) ($types[$ligne->type_analyse_causale_id] ?? ''));
            $colonne = str_contains($type, 'effet') || str_contains($type, 'conséquence') ? 'effet'
                : (str_contains($type, 'problème') || str_contains($type, 'probleme') ? 'probleme_identifie' : 'cause');
            DB::table('analyses_causales')->where('id', $ligne->id)->update([$colonne => $ligne->libelle]);
        }

        Schema::table('analyses_causales', function (Blueprint $table) {
            $table->string('libelle')->nullable()->change();
        });

        Schema::table('structures', function (Blueprint $table) {
            $table->string('email')->nullable()->after('telephone');
        });
    }

    public function down(): void
    {
        Schema::table('structures', function (Blueprint $table) {
            $table->dropColumn('email');
        });
        Schema::table('analyses_causales', function (Blueprint $table) {
            $table->dropColumn(['probleme_identifie', 'cause', 'effet']);
        });
    }
};
