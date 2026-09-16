<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('indicateurs', function (Blueprint $table) {
            $table->string('situation_reference')->nullable()->after('unite');
            $table->string('sources_verification')->nullable()->after('date_mesure');
            $table->string('hypothese')->nullable()->after('sources_verification');
            $table->foreignId('resultat_attendu_id')->nullable()->after('activite_id')->constrained('resultats_attendus')->nullOnDelete();
        });
    }
    public function down(): void {
        Schema::table('indicateurs', function (Blueprint $table) {
            $table->dropConstrainedForeignId('resultat_attendu_id');
            $table->dropColumn(['situation_reference', 'sources_verification', 'hypothese']);
        });
    }
};
