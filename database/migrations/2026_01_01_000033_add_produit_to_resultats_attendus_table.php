<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('resultats_attendus', function (Blueprint $table) {
            $table->string('produit')->nullable()->after('niveau');
        });
    }
    public function down(): void {
        Schema::table('resultats_attendus', function (Blueprint $table) {
            $table->dropColumn('produit');
        });
    }
};
