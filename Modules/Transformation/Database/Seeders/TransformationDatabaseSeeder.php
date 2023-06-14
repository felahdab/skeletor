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

        $this->call("TypeLicenceSeeder");
        $this->call("TypeFonctionSeeder");
        $this->call("StageSeeder");
        $this->call("SousObjectifSeeder");
        $this->call("ObjectifSeeder");
        $this->call("TacheSeeder");
        $this->call("TacheObjectif");

        $this->call("CompagnonageSeeder");
        $this->call("CompagnonageTache");
        $this->call("FonctionSeeder");
        $this->call("CompagnonageFonction");
        $this->call("FonctionStage");
        
        $this->call("CorrectUpdatedAtNullTimestamp");        
    }
}
