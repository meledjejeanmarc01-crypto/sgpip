<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('comites_projet', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['supervision', 'pilotage', 'technique', 'suivi_evaluation', 'audit_controle']);
            $table->string('role')->nullable();
            $table->text('composition')->nullable();
            $table->text('observation')->nullable();
            $table->foreignId('projet_id')->constrained('projets')->cascadeOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('comites_projet');
    }
};
