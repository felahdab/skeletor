<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Fonction;
use App\Models\Compagnonage;
use App\Models\Tache;
use App\Models\Objectif;
use App\Models\SousObjectif;

class CorrectUpdatedAtNullTimestamp extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ([Fonction::class, Compagnonage::class, Tache::class, Objectif::class, SousObjectif::class] as $className) {
            foreach ($className::where('updated_at', null)->get() as $object) {
                $object->updated_at = "2022/09/01";
                $object->save();
            }
            foreach ($className::where('created_at', null)->get() as $object) {
                $object->updated_at = "2022/09/01";
                $object->save();
            }
        }
    }
}
