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
                    CreateAdminUserSeeder::class,
                    create_ffast_roles::class,
                    DiplomeSeeder::class,
                    GradeSeeder::class,
                    GroupementSeeder::class,
                    SecteurSeeder::class,
                    ServiceSeeder::class,
                    SpecialiteSeeder::class,
                    UniteSeeder::class,
                    LieuSeeder::class,
                    FonctionSeeder::class,
                    TypeFonctionSeeder::class,
                    CompagnonageSeeder::class,
                    CompagnonageFonction::class,
                    TacheSeeder::class,
                    CompagnonageTache::class,
                    ObjectifSeeder::class,
                    TacheObjectif::class,
                    SousObjectifSeeder::class,
                    StageSeeder::class,
                    TypeLicenceSeeder::class,
                ]);

    }
}
