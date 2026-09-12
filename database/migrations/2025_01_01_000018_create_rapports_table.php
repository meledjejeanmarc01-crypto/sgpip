<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('rapports', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['avancement', 'financier', 'physique', 'suivi', 'annuel', 'trimestriel', 'mensuel', 'synthese', 'execution']);
            $table->string('titre');
            $table->longText('donnees')->nullable();
            $table->string('fichier')->nullable();
            $table->date('date');
            $table->foreignId('projet_id')->constrained('projets')->cascadeOnDelete();
            $table->foreignId('utilisateur_id')->constrained('users')->restrictOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('rapports');
    }
};
