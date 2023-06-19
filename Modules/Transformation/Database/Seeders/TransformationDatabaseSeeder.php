<?php

namespace Modules\Transformation\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class TransformationDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(TypeLicenceSeeder::class);
        $this->call(TypeFonctionSeeder::class);
        $this->call(StageSeeder::class);
        $this->call(ObjectifSeeder::class);
        $this->call(SousObjectifSeeder::class);
        
        $this->call(TacheSeeder::class);
        $this->call(TacheObjectif::class);

        $this->call(CompagnonageSeeder::class);
        $this->call(CompagnonageTache::class);
        $this->call(FonctionSeeder::class);
        $this->call(CompagnonageFonction::class);
        $this->call(FonctionStage::class);
        
        $this->call(CorrectUpdatedAtNullTimestamp::class);
    }
}
