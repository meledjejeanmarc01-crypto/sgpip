<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// MARCHÉ — cahier ajoute "Restes à engager" et "Charges à payer" à la liste des montants
// cumulés déjà présents (engagements/liquidations/paiements antérieurs).
return new class extends Migration {
    public function up(): void {
        Schema::table('marches', function (Blueprint $table) {
            $table->decimal('restes_a_engager', 18, 2)->nullable()->after('montant_paye');
            $table->decimal('charges_a_payer', 18, 2)->nullable()->after('restes_a_engager');
        });
    }
    public function down(): void {
        Schema::table('marches', function (Blueprint $table) {
            $table->dropColumn(['restes_a_engager', 'charges_a_payer']);
        });
    }
};
