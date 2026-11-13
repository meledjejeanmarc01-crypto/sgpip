<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// Propriétés du cahier des charges (§7) qui manquaient encore : modifications additives.
return new class extends Migration {
    public function up(): void
    {
        Schema::table('reformes', function (Blueprint $table) {
            $table->text('description')->nullable()->after('libelle');
        });

        Schema::table('parties_prenantes', function (Blueprint $table) {
            $table->string('role')->nullable()->after('libelle');
        });

        Schema::table('taches', function (Blueprint $table) {
            $table->enum('statut', ['a_faire', 'en_cours', 'termine'])->default('a_faire')->after('description');
        });

        Schema::table('financements', function (Blueprint $table) {
            $table->string('numero_convention')->nullable()->after('type_source');
            $table->date('date_convention')->nullable()->after('numero_convention');
        });

        Schema::table('localisations', function (Blueprint $table) {
            $table->enum('milieu', ['urbain', 'rural'])->nullable()->after('niveau_id');
            $table->foreignId('localisation_parent_id')->nullable()->after('milieu')->constrained('localisations')->nullOnDelete();
        });

        // Parent direct = ancêtre le plus proche renseigné (RG14).
        DB::statement('UPDATE localisations SET localisation_parent_id = COALESCE(
            NULLIF(sous_prefecture_id, id), NULLIF(commune_id, id), NULLIF(departement_id, id),
            NULLIF(region_id, id), NULLIF(district_id, id))');
    }

    public function down(): void
    {
        Schema::table('localisations', function (Blueprint $table) {
            $table->dropConstrainedForeignId('localisation_parent_id');
            $table->dropColumn('milieu');
        });
        Schema::table('financements', function (Blueprint $table) {
            $table->dropColumn(['numero_convention', 'date_convention']);
        });
        Schema::table('taches', function (Blueprint $table) {
            $table->dropColumn('statut');
        });
        Schema::table('parties_prenantes', function (Blueprint $table) {
            $table->dropColumn('role');
        });
        Schema::table('reformes', function (Blueprint $table) {
            $table->dropColumn('description');
        });
    }
};
