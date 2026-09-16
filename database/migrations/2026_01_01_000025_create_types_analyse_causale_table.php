<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('types_analyse_causale', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->timestamps();
        });
        DB::table('types_analyse_causale')->insert([
            ['libelle' => 'Cause immédiate', 'created_at' => now(), 'updated_at' => now()],
            ['libelle' => 'Cause sous-jacente', 'created_at' => now(), 'updated_at' => now()],
            ['libelle' => 'Cause structurelle', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
    public function down(): void {
        Schema::dropIfExists('types_analyse_causale');
    }
};
