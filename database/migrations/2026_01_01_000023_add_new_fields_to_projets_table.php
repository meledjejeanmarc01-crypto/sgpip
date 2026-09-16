<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('projets', function (Blueprint $table) {
            $table->string('appartenance')->nullable()->after('code_psgouv');
            $table->text('probleme')->nullable()->after('appartenance');
            $table->text('attentes_projet')->nullable()->after('probleme');
            $table->text('craintes_projet')->nullable()->after('attentes_projet');
            $table->string('taille')->nullable()->after('craintes_projet');
            $table->text('observations')->nullable()->after('taille');
        });
    }
    public function down(): void {
        Schema::table('projets', function (Blueprint $table) {
            $table->dropColumn(['appartenance', 'probleme', 'attentes_projet', 'craintes_projet', 'taille', 'observations']);
        });
    }
};
