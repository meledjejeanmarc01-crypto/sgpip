<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('cibles', function (Blueprint $table) {
            $table->id();
            $table->string('type_beneficiaire')->nullable();
            $table->string('acteur')->nullable();
            $table->text('probleme_specifique')->nullable();
            $table->text('attentes')->nullable();
            $table->text('craintes')->nullable();
            $table->foreignId('projet_id')->constrained('projets')->cascadeOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('cibles');
    }
};
