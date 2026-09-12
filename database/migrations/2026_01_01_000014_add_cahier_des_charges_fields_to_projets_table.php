<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('projets', function (Blueprint $table) {
            $table->string('code_pip')->nullable()->after('reference');
            $table->string('maitre_ouvrage')->nullable()->after('statut');
            $table->string('maitre_ouvrage_delegue')->nullable()->after('maitre_ouvrage');
            $table->string('maitre_oeuvre')->nullable()->after('maitre_ouvrage_delegue');
            $table->string('duree_prevue')->nullable()->after('maitre_oeuvre');
            $table->string('action_pnd')->nullable()->after('duree_prevue');
            $table->string('programme_budgetaire')->nullable()->after('action_pnd');
            $table->string('odd_concerne')->nullable()->after('programme_budgetaire');
            $table->string('domaine_impact_socio_eco')->nullable()->after('odd_concerne');
            $table->enum('milieu_execution', ['rural', 'urbain', 'inter_urbain', 'peri_urbain'])->nullable()->after('domaine_impact_socio_eco');
            $table->enum('type_projet', ['investissement', 'routine'])->default('investissement')->after('milieu_execution');
            $table->string('cible_trimestre_1')->nullable()->after('type_projet');
            $table->string('cible_trimestre_2')->nullable()->after('cible_trimestre_1');
            $table->string('cible_trimestre_3')->nullable()->after('cible_trimestre_2');
            $table->string('cible_trimestre_4')->nullable()->after('cible_trimestre_3');
            $table->string('code_pjgouv')->nullable()->after('cible_trimestre_4');
            $table->string('code_psgouv')->nullable()->after('code_pjgouv');
        });
    }
    public function down(): void {
        Schema::table('projets', function (Blueprint $table) {
            $table->dropColumn([
                'code_pip', 'maitre_ouvrage', 'maitre_ouvrage_delegue', 'maitre_oeuvre',
                'duree_prevue', 'action_pnd', 'programme_budgetaire', 'odd_concerne',
                'domaine_impact_socio_eco', 'milieu_execution', 'type_projet',
                'cible_trimestre_1', 'cible_trimestre_2', 'cible_trimestre_3', 'cible_trimestre_4',
                'code_pjgouv', 'code_psgouv',
            ]);
        });
    }
};
