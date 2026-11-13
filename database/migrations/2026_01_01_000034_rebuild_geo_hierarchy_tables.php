<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Reconstruit la hiérarchie géographique conformément au cahier des charges (section 7 + RG42-RG47) :
// ZONE D'EXECUTION -> DISTRICT -> REGION -> DEPARTEMENT -> COMMUNE -> SOUS_PREFECTURE -> VILLAGE
// Les modèles District/Region/Departement/Commune/SousPrefecture existaient déjà dans le code
// mais n'avaient jamais été migrés : cette migration crée les tables manquantes et corrige les
// rattachements (RG46 : sous-préfecture -> commune ; RG47 : village -> sous-préfecture).
return new class extends Migration {
    public function up(): void {
        Schema::create('districts', function (Blueprint $table) {
            $table->id();
            // RG42 : une zone d'exécution regroupe plusieurs districts ; un district a une seule zone d'exécution.
            $table->foreignId('zone_execution_id')->nullable()->constrained('zones_localisation')->nullOnDelete();
            $table->string('nom');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('regions', function (Blueprint $table) {
            $table->id();
            // RG43 : un district est composé de plusieurs régions ; une région appartient à un seul district.
            $table->foreignId('district_id')->constrained('districts')->cascadeOnDelete();
            $table->string('nom');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('departements', function (Blueprint $table) {
            $table->id();
            // RG44 : une région est composée de plusieurs départements ; un département appartient à une seule région.
            $table->foreignId('region_id')->constrained('regions')->cascadeOnDelete();
            $table->string('nom');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('communes', function (Blueprint $table) {
            $table->id();
            // RG45 : un département est composé de plusieurs communes ; une commune appartient à un seul département.
            $table->foreignId('departement_id')->constrained('departements')->cascadeOnDelete();
            $table->string('nom');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('sous_prefectures', function (Blueprint $table) {
            $table->id();
            // RG46 : une commune est composée de plusieurs sous-préfectures ; une sous-préfecture appartient à une seule commune.
            $table->foreignId('commune_id')->constrained('communes')->cascadeOnDelete();
            $table->string('nom');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('villages', function (Blueprint $table) {
            $table->id();
            // RG47 : une sous-préfecture est composée de plusieurs villages ; un village appartient à une seule sous-préfecture.
            $table->foreignId('sous_prefecture_id')->constrained('sous_prefectures')->cascadeOnDelete();
            $table->string('nom');
            $table->text('description')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('villages');
        Schema::dropIfExists('sous_prefectures');
        Schema::dropIfExists('communes');
        Schema::dropIfExists('departements');
        Schema::dropIfExists('regions');
        Schema::dropIfExists('districts');
    }
};
