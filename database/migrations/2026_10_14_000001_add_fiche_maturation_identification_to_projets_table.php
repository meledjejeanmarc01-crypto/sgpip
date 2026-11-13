<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Fiche de maturation, étape 1 : sections 1 à 4
// (intitulé, maîtrise d'ouvrage et d'œuvre, personnes ressources, périmètre, attributions du Ministère).
return new class extends Migration
{
    private array $colonnes = [
        'date_identification' => 'date',
        'maitre_ouvrage_associe' => 'string',
        'maitre_oeuvre_delegue' => 'string',
        'maitre_oeuvre_associe' => 'string',
        'section_budgetaire' => 'string',
        'responsable_nom' => 'string',
        'responsable_fonction' => 'string',
        'responsable_telephone' => 'string',
        'responsable_cellulaire' => 'string',
        'responsable_email' => 'string',
        'responsable_adresse' => 'string',
        'redacteur_nom' => 'string',
        'redacteur_fonction' => 'string',
        'redacteur_telephone' => 'string',
        'redacteur_cellulaire' => 'string',
        'redacteur_email' => 'string',
        'redacteur_adresse' => 'string',
        'perimetre_sections' => 'json',
        'attributions_ministere' => 'text',
    ];

    public function up(): void
    {
        Schema::table('projets', function (Blueprint $table) {
            foreach ($this->colonnes as $nom => $type) {
                if (! Schema::hasColumn('projets', $nom)) {
                    $table->{$type}($nom)->nullable();
                }
            }
        });
    }

    public function down(): void
    {
        Schema::table('projets', function (Blueprint $table) {
            foreach (array_keys($this->colonnes) as $nom) {
                if (Schema::hasColumn('projets', $nom)) {
                    $table->dropColumn($nom);
                }
            }
        });
    }
};
