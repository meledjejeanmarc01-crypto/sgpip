<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('zones_localisation', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['district', 'region', 'departement', 'sous_prefecture', 'commune', 'localite']);
            $table->string('libelle');
            $table->foreignId('parent_id')->nullable()->constrained('zones_localisation')->nullOnDelete();
            $table->decimal('latitude', 10, 6)->nullable();
            $table->decimal('longitude', 10, 6)->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('zones_localisation');
    }
};
