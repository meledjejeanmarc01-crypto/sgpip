<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('types_partie_prenante', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->timestamps();
        });
        Schema::table('parties_prenantes', function (Blueprint $table) {
            $table->foreignId('type_partie_prenante_id')->nullable()->after('projet_id')->constrained('types_partie_prenante')->nullOnDelete();
        });
    }
    public function down(): void {
        Schema::table('parties_prenantes', function (Blueprint $table) {
            $table->dropConstrainedForeignId('type_partie_prenante_id');
        });
        Schema::dropIfExists('types_partie_prenante');
    }
};
