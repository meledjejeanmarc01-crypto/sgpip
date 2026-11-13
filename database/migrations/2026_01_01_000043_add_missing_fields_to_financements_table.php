<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// FINANCEMENT — cahier : "id, devise, date, taux_change, montant, état, ressources internes,
// ressources externes, observation, bailleur_id, projet_id". Le champ 'etat_id' existant
// référence déjà l'État en tant que financeur institutionnel (RG "État acteur institutionnel") ;
// 'statut' porte ici la notion distincte de statut/état d'avancement du financement.
return new class extends Migration {
    public function up(): void {
        Schema::table('financements', function (Blueprint $table) {
            $table->string('devise')->default('XOF')->after('reference');
            $table->decimal('taux_change', 12, 4)->nullable()->after('devise');
            $table->decimal('ressources_internes', 18, 2)->nullable()->after('taux_change');
            $table->decimal('ressources_externes', 18, 2)->nullable()->after('ressources_internes');
            $table->string('statut')->nullable()->after('ressources_externes');
            $table->text('observation')->nullable()->after('statut');
        });
    }
    public function down(): void {
        Schema::table('financements', function (Blueprint $table) {
            $table->dropColumn(['devise', 'taux_change', 'ressources_internes', 'ressources_externes', 'statut', 'observation']);
        });
    }
};
