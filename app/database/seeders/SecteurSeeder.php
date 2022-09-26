<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class SecteurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
            [1, 'RSO', 'Réseaux', 3],
            [2, 'TELECOM', 'Télécommunications', 3],
            [3, 'SDC', 'Système de combat', 2],
            [4, 'GE', 'Guerre électronique', 2],
            [5, 'DEM', 'Détecteur électromagnétique', 2],
            [6, 'ARM', 'Armes', 4],
            [7, 'LSM', 'Lutte sous marine', 5],
            [8, 'AVIA', 'Aviation', 5],
            [9, 'MACH', 'Machine', 6],
            [10, 'FLOT', 'Flotteur', 6],
            [11, 'LOG', 'Logistique', 6],
            [12, 'ELEC', 'Électricité', 7],
            [13, 'SECU', 'Sécurité', 7],
            [14, 'ADM', 'Administration', 10],
            [15, 'VIVRES', 'Vivres', 10],
            [16, 'TIM', 'Timonerie', 11],
            [17, 'MAN', 'Manœuvre', 11],
            [18, 'SC', 'Service courant', 11],
            [19, 'SANTE', 'Santé', 8],
            [20, 'EM', 'État-major', 9]
            ];
        foreach ($records as $record){
            DB::insert('insert into secteurs (id, secteur_libcourt, secteur_liblong, service_id) values (?, ?, ?, ?)', $record);
        }
    }
}
