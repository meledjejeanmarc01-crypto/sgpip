<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// TYPE_DOCUMENT — RG39 : "Un TypeDocument peut être attribué à plusieurs Documents,
// un Document ne possède qu'un seul TypeDocument."
// DOCUMENT — cahier : "id, libéllé, source, stratégie, projet_id, utilisateur_id".
// La table 'documents' existante conserve ses champs techniques (fichier, taille, extension)
// nécessaires au stockage réel des fichiers, et gagne les champs métier du cahier des charges.
return new class extends Migration {
    public function up(): void {
        Schema::create('types_document', function (Blueprint $table) {
            $table->id();
            $table->string('libelle')->unique();
            $table->timestamps();
        });

        Schema::table('documents', function (Blueprint $table) {
            $table->foreignId('type_document_id')->nullable()->after('projet_id')
                ->constrained('types_document')->nullOnDelete();
            $table->string('source')->nullable()->after('description');
            $table->string('strategie')->nullable()->after('source');
        });
    }

    public function down(): void {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropConstrainedForeignId('type_document_id');
            $table->dropColumn(['source', 'strategie']);
        });
        Schema::dropIfExists('types_document');
    }
};
