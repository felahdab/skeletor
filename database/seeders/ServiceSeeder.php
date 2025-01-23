<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
            [2, 'LAS', 'Lutte au dessus de la surface', 4],
            [3, 'SIC', 'Système d\'information et de communication', 4],
            [4, 'ARM', 'Armes', 4],
            [5, 'LSM AVIA', 'Lutte sous la mer / Aviation', 4],
            [6, 'MACH FLOT', 'Machine/Flotteur', 3],
            [7, 'ELEC SECU', 'Électricité/Sécurité', 3],
            [8, 'SANTE', 'Santé', 2],
            [9, 'EM', 'État-Major', 1],
            [10, 'CMA', 'Commissariat', 2],
            [11, 'PONT', 'Pont', 2]
        ];
        foreach ($records as $record){
            DB::insert('insert into services (id, service_libcourt, service_liblong, groupement_id) values (?, ?, ?, ?)', $record);
        }
    }
}
