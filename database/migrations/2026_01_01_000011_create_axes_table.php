<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('axes', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->foreignId('programme_id')->constrained('programmes')->cascadeOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('axes');
    }
};
