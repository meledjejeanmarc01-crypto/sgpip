<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// §9.4 : saisir un projet, le soumettre pour validation, puis le valider (ou le rejeter) et notifier la décision.
return new class extends Migration {
    public function up(): void
    {
        Schema::table('projets', function (Blueprint $table) {
            $table->enum('statut_validation', ['brouillon', 'soumis', 'valide', 'rejete'])->default('brouillon')->after('statut');
            $table->text('motif_decision')->nullable()->after('statut_validation');
            $table->timestamp('date_soumission')->nullable()->after('motif_decision');
            $table->timestamp('date_decision')->nullable()->after('date_soumission');
            $table->foreignId('decide_par')->nullable()->after('date_decision')->constrained('users')->nullOnDelete();
        });

        // Les projets déjà enregistrés avant l'introduction du circuit sont considérés comme validés.
        DB::table('projets')->update(['statut_validation' => 'valide']);
    }

    public function down(): void
    {
        Schema::table('projets', function (Blueprint $table) {
            $table->dropConstrainedForeignId('decide_par');
            $table->dropColumn(['statut_validation', 'motif_decision', 'date_soumission', 'date_decision']);
        });
    }
};
