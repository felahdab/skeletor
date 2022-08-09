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
			[9, 'AVG_A', 'AUVERGNE A'],
			[10, 'AVG_B', 'AUVERGNE B'],
			[11, 'BTE_A', 'BRETAGNE A'],
			[12, 'BTE_B', 'BRETAGNE B'],
			[13, 'NMD_A', 'NORMANDIE A'],
			[14, 'NMD_B', 'NORMANDIE B'],
			[15, 'ALS_A', 'ALSACE A'],
			[16, 'ALS_B', 'ALSACE B'],
			[17, 'LRN_A', 'LORRAINE A'],
			[18, 'LRN_B', 'LORRAINE B'],
			[19, 'HE', 'HORS ESCOUADE']
			];
		foreach ($records as $record){
			DB::insert('insert into unites (id, unite_libcourt, unite_liblong) values (?, ?, ?)', $record);
		}
    }
}
