<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// PARTIE_PRENANTE — cahier : "id, libéllé, sig, projet_id, Type partie prenante_id".
return new class extends Migration {
    public function up(): void {
        Schema::table('parties_prenantes', function (Blueprint $table) {
            $table->string('libelle')->nullable()->after('id');
            $table->string('sig')->nullable()->after('libelle');
        });

        DB::table('parties_prenantes')->update([
            'libelle' => DB::raw('groupe_acteurs'),
        ]);

        Schema::table('parties_prenantes', function (Blueprint $table) {
            $table->dropColumn(['groupe_acteurs', 'role']);
        });
    }

    public function down(): void {
        Schema::table('parties_prenantes', function (Blueprint $table) {
            $table->string('groupe_acteurs')->nullable();
            $table->string('role')->nullable();
        });
        DB::table('parties_prenantes')->update(['groupe_acteurs' => DB::raw('libelle')]);
        Schema::table('parties_prenantes', function (Blueprint $table) {
            $table->dropColumn(['libelle', 'sig']);
        });
    }
};
