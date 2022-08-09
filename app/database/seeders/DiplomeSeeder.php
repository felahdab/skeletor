<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Diplome;

class DiplomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Diplome::create([
			'id'             => 1,
			'diplome_libcourt' => 'BE',
			'diplome_liblong'  => 'Brevet élémentaire',
			'ordre_classmt'  => 1,
        ]);
		Diplome::create([
			'id'             => 2,
			'diplome_libcourt' => 'BAT',
			'diplome_liblong'  => 'Brevet d\'aptitude technique',
			'ordre_classmt'  => 2,
        ]);
		Diplome::create([
			'id'             => 3,
			'diplome_libcourt' => 'BS',
			'diplome_liblong'  => 'Brevet supérieur',
			'ordre_classmt'  => 3,
        ]);
		Diplome::create([
			'id'             => 4,
			'diplome_libcourt' => 'BM',
			'diplome_liblong'  => 'Brevet de maitrise',
			'ordre_classmt'  => 4,
        ]);
		Diplome::create([
			'id'             => 5,
			'diplome_libcourt' => 'OFF',
			'diplome_liblong'  => 'Officier',
			'ordre_classmt'  => 5,
        ]);
    }
}
