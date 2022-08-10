<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class TypeLicenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
			[0, 'Pas de licence', ''],
			[1, 'Licence 1', ''],
			[2, 'Licence 2', ''],
			[3, 'Licence 3', '']
		];
		foreach ($records as $record){
			DB::insert('insert into type_licences (id, typlicense_libcourt, typlicense_liblong) values (?, ?, ?)', $record);
		}
    }
}
