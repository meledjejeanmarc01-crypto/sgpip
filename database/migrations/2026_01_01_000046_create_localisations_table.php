<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// LOCALISATION — cahier : "id, libellé, code, niveau_id, district_id, region_id,
// departement_id, commune_id, sous_prefecture_id".
// Une seule table porte toute la hiérarchie District > Région > Département > Commune
// > Sous-préfecture > Village. Au lieu d'un parent_id générique, chaque ligne porte
// directement une colonne par niveau d'ancêtre : une commune a directement son
// departement_id, region_id et district_id renseignés (la colonne du niveau de la
// ligne elle-même, et celles des niveaux en dessous, restent nulles).
return new class extends Migration {
    public function up(): void {
        Schema::create('localisations', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->string('code')->nullable()->unique();
            $table->text('description')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            // RG43 : une localisation appartient à un seul niveau.
            $table->foreignId('niveau_id')->constrained('niveau_localisations')->restrictOnDelete();

            // RG44/RG45 : une colonne par niveau d'ancêtre, toutes nullables (un district
            // n'a aucune de ces colonnes remplie ; un village les a toutes remplies).
            $table->foreignId('district_id')->nullable()->constrained('localisations')->nullOnDelete();
            $table->foreignId('region_id')->nullable()->constrained('localisations')->nullOnDelete();
            $table->foreignId('departement_id')->nullable()->constrained('localisations')->nullOnDelete();
            $table->foreignId('commune_id')->nullable()->constrained('localisations')->nullOnDelete();
            $table->foreignId('sous_prefecture_id')->nullable()->constrained('localisations')->nullOnDelete();

            $table->timestamps();

            $table->index(['niveau_id', 'district_id', 'region_id', 'departement_id', 'commune_id', 'sous_prefecture_id'], 'localisations_hierarchie_index');
        });
    }

    public function down(): void {
        Schema::dropIfExists('localisations');
    }
};
