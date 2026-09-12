<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('projets', function (Blueprint $table) {
            $table->foreignId('axe_id')->nullable()->after('zone_localisation_id')->constrained('axes')->nullOnDelete();
        });
    }
    public function down(): void {
        Schema::table('projets', function (Blueprint $table) {
            $table->dropConstrainedForeignId('axe_id');
        });
    }
};
