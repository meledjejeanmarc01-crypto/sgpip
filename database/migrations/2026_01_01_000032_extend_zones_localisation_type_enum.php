<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        if (Schema::getConnection()->getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE zones_localisation MODIFY COLUMN type ENUM('district','region','departement','sous_prefecture','commune','localite','village','hors_ci') NOT NULL");
        }
    }
    public function down(): void {
        if (Schema::getConnection()->getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE zones_localisation MODIFY COLUMN type ENUM('district','region','departement','sous_prefecture','commune','localite') NOT NULL");
        }
    }
};
