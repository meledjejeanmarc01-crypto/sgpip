<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// ZONE D'EXECUTION — cahier : "Propriétés principales : id, libellé, pays".
// La hiérarchie district/région/.../village est désormais portée par ses propres tables
// (voir migration rebuild_geo_hierarchy_tables), donc les colonnes 'type' et 'parent_id'
// qui servaient à une hiérarchie générique auto-référencée ne sont plus nécessaires ici.
// RG48 : ajoute le rattachement optionnel à un pays étranger pour les zones "Hors CI".
return new class extends Migration {
    public function up(): void {
        Schema::table('zones_localisation', function (Blueprint $table) {
            $table->string('pays')->nullable()->after('libelle');
            $table->foreignId('pays_etranger_id')->nullable()->after('pays')
                ->constrained('pays_etrangers')->nullOnDelete();
        });

        if (Schema::hasColumn('zones_localisation', 'parent_id')) {
            Schema::table('zones_localisation', function (Blueprint $table) {
                $table->dropConstrainedForeignId('parent_id');
            });
        }
        if (Schema::hasColumn('zones_localisation', 'type')) {
            Schema::table('zones_localisation', function (Blueprint $table) {
                $table->dropColumn('type');
            });
        }
    }

    public function down(): void {
        Schema::table('zones_localisation', function (Blueprint $table) {
            $table->enum('type', ['district', 'region', 'departement', 'sous_prefecture', 'commune', 'localite', 'village', 'hors_ci'])
                ->default('district');
            $table->foreignId('parent_id')->nullable()->constrained('zones_localisation')->nullOnDelete();
            $table->dropConstrainedForeignId('pays_etranger_id');
            $table->dropColumn('pays');
        });
    }
};
