<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// RG17 : un projet est géré par un ou plusieurs utilisateurs ; un utilisateur peut gérer plusieurs projets.
return new class extends Migration {
    public function up(): void
    {
        Schema::create('projet_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('projet_id')->constrained('projets')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['projet_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projet_user');
    }
};
