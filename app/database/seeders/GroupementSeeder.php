<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Groupement;

class GroupementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Groupement::create([
			'id'             => 1,
			'groupement_libcourt' => 'EM',
			'groupement_liblong'  => 'Etat-Major',
        ]);
		Groupement::create([
			'id'             => 2,
			'groupement_libcourt' => 'EQUIP',
			'groupement_liblong'  => 'Equipage',
        ]);
		Groupement::create([
			'id'             => 3,
			'groupement_libcourt' => 'NAV',
			'groupement_liblong'  => 'Navire',
        ]);
		Groupement::create([
			'id'             => 4,
			'groupement_libcourt' => 'OPS',
			'groupement_liblong'  => 'Opérations',
        ]);
    }
}
