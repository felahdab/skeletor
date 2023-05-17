<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
                    PermissionsSeeder::class,
                    RolesSeeder::class,
                    DiplomeSeeder::class,
                    GradeSeeder::class,
                    GroupementSeeder::class,
                    ServiceSeeder::class,
                    SecteurSeeder::class,
                    SpecialiteSeeder::class,
                    UniteSeeder::class,
                    CreateAdminUserSeeder::class,
                    LieuSeeder::class,
                    TypeFonctionSeeder::class,
                    FonctionSeeder::class,
                    CompagnonageSeeder::class,
                    TacheSeeder::class,
                    ObjectifSeeder::class,
                    SousObjectifSeeder::class,
                    TypeLicenceSeeder::class,
                    StageSeeder::class,
                    FonctionStage::class,
                    LiensSeeder::class,
                    CompagnonageFonction::class,
                    CompagnonageTache::class,
                    TacheObjectif::class,
                    CorrectUpdatedAtNullTimestamp::class
                ]);

    }
}
