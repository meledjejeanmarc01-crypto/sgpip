<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// ÉTAT n'est pas une entité du cahier des charges (51 entités) : "état" n'y apparaît que
// comme un champ de statut (financement, marché), jamais comme acteur institutionnel distinct.
// Un FINANCEMENT est rattaché à un seul bailleur (jamais à un État), conformément au cahier.
return new class extends Migration {
    public function up(): void {
        if (Schema::hasColumn('financements', 'etat_id')) {
            Schema::table('financements', function (Blueprint $table) {
                $table->dropConstrainedForeignId('etat_id');
            });
        }
        Schema::dropIfExists('etats');
    }

    public function down(): void {
        Schema::create('etats', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->string('sigle')->nullable();
            $table->string('adresse')->nullable();
            $table->timestamps();
        });
        Schema::table('financements', function (Blueprint $table) {
            $table->foreignId('etat_id')->nullable()->constrained('etats')->nullOnDelete();
        });
    }
};
