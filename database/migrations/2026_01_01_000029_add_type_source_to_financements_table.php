<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('financements', function (Blueprint $table) {
            $table->enum('type_source', [
                'tresor', 'emprunt', 'don', 'participation_collectivites',
                'participation_populations', 'participation_secteur_prive',
                'ppp', 'fonds_propres_parapublics',
            ])->nullable()->after('reference');
        });
    }
    public function down(): void {
        Schema::table('financements', function (Blueprint $table) {
            $table->dropColumn('type_source');
        });
    }
};
