<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class UniteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
            [1, 'GTR/B', 'GTR BREST'],
            [2, 'GTR/T', 'GTR TOULON'],
            [3, 'AQN_A', 'AQUITAINE A'],
            [4, 'AQN_B', 'AQUITAINE B'],
            [5, 'PCE_A', 'PROVENCE A'],
            [6, 'PCE_B', 'PROVENCE B'],
            [7, 'LGC_A', 'LANGUEDOC A'],
            [8, 'LGC_B', 'LANGUEDOC B'],
            [9, 'AVG', 'AUVERGNE'],
            [10, 'BTE_A', 'BRETAGNE A'],
            [11, 'BTE_B', 'BRETAGNE B'],
            [12, 'NMD', 'NORMANDIE'],
            [13, 'ALS', 'ALSACE'],
            [14, 'LRN', 'LORRAINE'],
            [15, 'HE', 'HORS ESCOUADE'],
            [16, 'FCM', 'Formation Continue Modularisée']
            ];
        foreach ($records as $record){
            DB::insert('insert into unites (id, unite_libcourt, unite_liblong) values (?, ?, ?)', $record);
        }
    }
}
