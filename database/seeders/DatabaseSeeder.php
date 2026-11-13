<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UtilisateurSeeder::class,
            TypeStructureSeeder::class,
            StructureSeeder::class,
            SecteurSeeder::class,
            NiveauLocalisationSeeder::class,
            ZoneLocalisationSeeder::class,
            LocalisationCoordinatesSeeder::class,
            TypeBailleurSeeder::class,
            BailleurSeeder::class,
            ProgrammeFichePipSeeder::class,
            ProjetDemoSeeder::class,
            CahierDesChargesCompletSeeder::class,
        ]);
    }
}
