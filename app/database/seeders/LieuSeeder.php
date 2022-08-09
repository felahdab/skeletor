<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class LieuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
			[1, 'PEM', 'Pole Ecole Mediterranne'],
			[2, 'Bord', ' à bord d\'une FREMM'],
			[3, 'GTR', 'toulon ou brest'],
			[4, 'GTR ou Bord', ''],
			[5, 'GTR et Bord', ''],
			[6, 'CFPES', ''],
			[7, 'ESCO', ''],
			[8, 'EXT', ''],
			[9, 'ALFAN', '']
			];
		foreach ($records as $record){
			DB::insert('insert into lieux (id, lieu_libcourt, lieu_liblong) values (?, ?, ?)', $record);
		}
    }
}
