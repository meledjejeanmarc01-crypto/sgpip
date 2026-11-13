<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// Alignement des propriétés des entités sur le cahier des charges (§7) — modifications additives,
// sauf Risque : la « criticité » devient l'« impact » (valeurs conservées).
return new class extends Migration {
    public function up(): void
    {
        // RISQUE : probabilité, impact
        Schema::table('risques', function (Blueprint $table) {
            $table->enum('impact', ['faible', 'moyenne', 'elevee'])->default('moyenne')->after('probabilite');
        });
        DB::table('risques')->update(['impact' => DB::raw('criticite')]);
        Schema::table('risques', function (Blueprint $table) {
            $table->dropColumn('criticite');
        });

        // ÉTUDE : type d'étude, date de réalisation
        Schema::table('etudes', function (Blueprint $table) {
            $table->string('type_etude')->nullable()->after('libelle');
            $table->date('date_realisation')->nullable()->after('type_etude');
        });

        // RAPPORT : période
        Schema::table('rapports', function (Blueprint $table) {
            $table->string('periode')->nullable()->after('titre');
        });

        // OBJECTIF : type d'objectif
        Schema::table('objectifs_specifiques', function (Blueprint $table) {
            $table->enum('type_objectif', ['global', 'specifique'])->default('specifique')->after('libelle');
        });

        // PAYS ÉTRANGER : code ISO
        Schema::table('pays_etrangers', function (Blueprint $table) {
            $table->string('code_iso', 3)->nullable()->after('libelle');
        });

        // BAILLEUR : pays étranger (un pays peut correspondre à plusieurs bailleurs)
        Schema::table('bailleurs', function (Blueprint $table) {
            $table->foreignId('pays_etranger_id')->nullable()->after('type_bailleur_id')->constrained('pays_etrangers')->nullOnDelete();
        });

        // RG16 : un acteur appartient à une seule partie prenante
        Schema::table('acteurs', function (Blueprint $table) {
            $table->foreignId('partie_prenante_id')->nullable()->after('groupe_acteur_id')->constrained('parties_prenantes')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('acteurs', function (Blueprint $table) {
            $table->dropConstrainedForeignId('partie_prenante_id');
        });
        Schema::table('bailleurs', function (Blueprint $table) {
            $table->dropConstrainedForeignId('pays_etranger_id');
        });
        Schema::table('pays_etrangers', function (Blueprint $table) {
            $table->dropColumn('code_iso');
        });
        Schema::table('objectifs_specifiques', function (Blueprint $table) {
            $table->dropColumn('type_objectif');
        });
        Schema::table('rapports', function (Blueprint $table) {
            $table->dropColumn('periode');
        });
        Schema::table('etudes', function (Blueprint $table) {
            $table->dropColumn(['type_etude', 'date_realisation']);
        });
        Schema::table('risques', function (Blueprint $table) {
            $table->enum('criticite', ['faible', 'moyenne', 'elevee'])->default('moyenne')->after('probabilite');
        });
        DB::table('risques')->update(['criticite' => DB::raw('impact')]);
        Schema::table('risques', function (Blueprint $table) {
            $table->dropColumn('impact');
        });
    }
};
