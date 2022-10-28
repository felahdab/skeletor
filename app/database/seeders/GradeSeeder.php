<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Grade;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Grade::create([
			'id'             => 1,
			'grade_libcourt' => 'AL',
			'grade_liblong'  => 'AMIRAL',
			'ordre_classmt'  => 20,
        ]);
		Grade::create([
			'id'             => 2,
			'grade_libcourt' => 'VAE',
			'grade_liblong'  => 'VICE AMIRAL D ESCADRE',
			'ordre_classmt'  => 19,
        ]);
		Grade::create([
			'id'             => 3,
			'grade_libcourt' => 'VA',
			'grade_liblong'  => 'VICE AMIRAL',
			'ordre_classmt'  => 18,
        ]);
		Grade::create([
			'id'             => 4,
			'grade_libcourt' => 'CA',
			'grade_liblong'  => 'CONTRE AMIRAL',
			'ordre_classmt'  => 17,
        ]);
		Grade::create([
			'id'             => 5,
			'grade_libcourt' => 'CV',
			'grade_liblong'  => 'CAPITAINE DE VAISSEAU',
			'ordre_classmt'  => 16,
        ]);
		Grade::create([
			'id'             => 6,
			'grade_libcourt' => 'CF',
			'grade_liblong'  => 'CAPITAINE DE FREGATE',
			'ordre_classmt'  => 15,
        ]);
		Grade::create([
			'id'             => 7,
			'grade_libcourt' => 'CC',
			'grade_liblong'  => 'CAPITAINE DE CORVETTE',
			'ordre_classmt'  => 14,
        ]);
		Grade::create([
			'id'             => 8,
			'grade_libcourt' => 'LV',
			'grade_liblong'  => 'LIEUTENANT DE VAISSEAU',
			'ordre_classmt'  => 13,
        ]);
		Grade::create([
			'id'             => 9,
			'grade_libcourt' => 'EV1',
			'grade_liblong'  => 'ENSEIGNE DE VAISSEAU DE 1ERE CLASSE',
			'ordre_classmt'  => 12,
        ]);
		Grade::create([
			'id'             => 10,
			'grade_libcourt' => 'EV2',
			'grade_liblong'  => 'ENSEIGNE DE VAISSEAU DE 2EME CLASSE',
			'ordre_classmt'  => 11,
        ]);
		Grade::create([
			'id'             => 11,
			'grade_libcourt' => 'ASP',
			'grade_liblong'  => 'ASPIRANT',
			'ordre_classmt'  => 10,
        ]);
		Grade::create([
			'id'             => 12,
			'grade_libcourt' => 'MAJ',
			'grade_liblong'  => 'MAJOR',
			'ordre_classmt'  => 9,
        ]);
		Grade::create([
			'id'             => 13,
			'grade_libcourt' => 'MP',
			'grade_liblong'  => 'MAITRE PRINCIPAL',
			'ordre_classmt'  => 8,
        ]);
		Grade::create([
			'id'             => 14,
			'grade_libcourt' => 'PM',
			'grade_liblong'  => 'PREMIER MAITRE',
			'ordre_classmt'  => 7,
        ]);
		Grade::create([
			'id'             => 15,
			'grade_libcourt' => 'MT',
			'grade_liblong'  => 'MAITRE',
			'ordre_classmt'  => 6,
        ]);
		Grade::create([
			'id'             => 16,
			'grade_libcourt' => 'SM',
			'grade_liblong'  => 'SECOND MAITRE',
			'ordre_classmt'  => 5,
        ]);
		Grade::create([
			'id'             => 17,
			'grade_libcourt' => 'SMQ',
			'grade_liblong'  => 'MAISTRANCIER',
			'ordre_classmt'  => 4,
        ]);
		Grade::create([
			'id'             => 18,
			'grade_libcourt' => 'QM1',
			'grade_liblong'  => 'QUARTIER MAITRE DE 1ERE CLASSE',
			'ordre_classmt'  => 3,
        ]);
		Grade::create([
			'id'             => 19,
			'grade_libcourt' => 'QM2',
			'grade_liblong'  => 'QUARTIER MAITRE DE 2EME CLASSE',
			'ordre_classmt'  => 2,
        ]);
		Grade::create([
			'id'             => 20,
			'grade_libcourt' => 'MO1',
			'grade_liblong'  => 'MATELOT',
			'ordre_classmt'  => 1,
        ]);
        Grade::create([
			'id'             => 21,
			'grade_libcourt' => 'MO2',
			'grade_liblong'  => 'MATELOT',
			'ordre_classmt'  => 0,
        ]);
    }
}
