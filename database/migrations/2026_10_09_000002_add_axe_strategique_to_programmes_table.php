<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Cahier des charges §7 — PROGRAMME : propriété « axe stratégique ».
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('programmes', 'axe_strategique')) {
            Schema::table('programmes', function (Blueprint $table) {
                $table->string('axe_strategique')->nullable()->after('libelle');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('programmes', 'axe_strategique')) {
            Schema::table('programmes', function (Blueprint $table) {
                $table->dropColumn('axe_strategique');
            });
        }
    }
};
