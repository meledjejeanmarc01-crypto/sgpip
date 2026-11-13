<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

// RG19 : un projet dont l'avancement atteint 100 % peut faire l'objet d'un rapport de clôture.
return new class extends Migration {
    public function up(): void
    {
        if (in_array(DB::getDriverName(), ['mysql', 'mariadb'], true)) {
            DB::statement("ALTER TABLE rapports MODIFY type ENUM('avancement','financier','physique','suivi','annuel','trimestriel','mensuel','synthese','execution','cloture') NOT NULL");
        }
    }

    public function down(): void
    {
        DB::table('rapports')->where('type', 'cloture')->update(['type' => 'synthese']);
        if (in_array(DB::getDriverName(), ['mysql', 'mariadb'], true)) {
            DB::statement("ALTER TABLE rapports MODIFY type ENUM('avancement','financier','physique','suivi','annuel','trimestriel','mensuel','synthese','execution') NOT NULL");
        }
    }
};
