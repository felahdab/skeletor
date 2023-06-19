<?php

namespace Modules\Transformation\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class TypeFonctionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
			[1, 'mer', 'fonction à la mer'],
			[2, 'quai', 'fonction à quai'],
			[3, 'metier', 'fonction métier']
		];
		foreach ($records as $record){
			DB::insert('insert into transformation_type_fonctions (id, typfonction_libcourt, typfonction_liblong) values (?, ?, ?)', $record);
		}
    }
}
