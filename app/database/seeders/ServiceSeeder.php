<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Service::create([
			'id'             => 2,
			'service_libcourt' => 'LAS',
			'service_liblong'  => 'Lutte au dessus de la surface',
			'groupement_id'  => 4,
        ]);
		Service::create([
			'id'             => 3,
			'service_libcourt' => 'SIC',
			'service_liblong'  => 'Systèmes d\'information et de communication',
			'groupement_id'  => 4,
        ]);
		Service::create([
			'id'             => 4,
			'service_libcourt' => 'ARM',
			'service_liblong'  => 'Armes',
			'groupement_id'  => 4,
        ]);
		Service::create([
			'id'             => 5,
			'service_libcourt' => 'LSM AVIA',
			'service_liblong'  => 'Lutte sous la mer / Aviation',
			'groupement_id'  => 4,
        ]);
		Service::create([
			'id'             => 6,
			'service_libcourt' => 'MACH FLOT',
			'service_liblong'  => 'Machine/Flotteur',
			'groupement_id'  => 3,
        ]);
		Service::create([
			'id'             => 7,
			'service_libcourt' => 'ELEC SECU',
			'service_liblong'  => 'Electricité/Sécurité',
			'groupement_id'  => 3,
        ]);
		Service::create([
			'id'             => 8,
			'service_libcourt' => 'SANTE',
			'service_liblong'  => 'Santé',
			'groupement_id'  => 2,
        ]);
		Service::create([
			'id'             => 9,
			'service_libcourt' => 'EM',
			'service_liblong'  => 'Etat-major',
			'groupement_id'  => 1,
        ]);
		Service::create([
			'id'             => 10,
			'service_libcourt' => 'CMA',
			'service_liblong'  => 'Commissariat',
			'groupement_id'  => 2,
        ]);
		Service::create([
			'id'             => 11,
			'service_libcourt' => 'PONT',
			'service_liblong'  => 'Pont',
			'groupement_id'  => 2,
        ]);
    }
}
