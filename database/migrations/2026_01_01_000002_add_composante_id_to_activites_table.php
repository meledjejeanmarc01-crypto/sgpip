<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('activites', function (Blueprint $table) {
            $table->foreignId('composante_id')->nullable()->after('projet_id')->constrained('composantes')->nullOnDelete();
            $table->decimal('cout_previsionnel', 18, 2)->nullable()->after('taux_avancement');
        });
    }
    public function down(): void {
        Schema::table('activites', function (Blueprint $table) {
            $table->dropConstrainedForeignId('composante_id');
            $table->dropColumn('cout_previsionnel');
        });
    }
};
