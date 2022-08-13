<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class CompagnonageFonction extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
			[100, 6, 31],
			[99, 6, 24],
			[92, 7, 20],
			[102, 5, 20],
			[98, 6, 20],
			[101, 6, 39],
			[97, 8, 38],
			[96, 8, 28],
			[95, 8, 20],
			[94, 7, 29],
			[93, 7, 26],
			[91, 87, 73],
			[103, 5, 71],
			[104, 5, 17],
			[105, 5, 30],
			[106, 5, 27],
			[107, 5, 41],
			[108, 4, 20],
			[109, 4, 21],
			[110, 4, 32],
			[111, 4, 25],
			[112, 4, 71],
			[113, 4, 40],
			[114, 3, 20],
			[115, 3, 33],
			[116, 3, 23],
			[117, 3, 36],
			[118, 2, 20],
			[119, 2, 22],
			[120, 2, 34],
			[121, 2, 19],
			[122, 2, 35],
			[123, 1, 20],
			[124, 1, 18],
			[125, 1, 37],
			[126, 54, 70],
			[127, 14, 68],
			[128, 46, 71],
			[129, 55, 64],
			[130, 55, 67],
			[131, 67, 65],
			[132, 67, 67],
			[133, 47, 66],
			[134, 52, 49],
			[135, 15, 50],
			[136, 13, 47],
			[137, 13, 48],
			[138, 86, 47],
			[139, 86, 44],
			[140, 49, 46],
			[141, 50, 45],
			[142, 80, 63],
			[150, 80, 58],
			[151, 48, 63],
			[152, 48, 62],
			[146, 39, 63],
			[147, 39, 61],
			[148, 39, 56],
			[149, 39, 57],
			[153, 48, 57],
			[154, 48, 58],
			[155, 56, 60],
			[156, 68, 59],
			[157, 85, 63],
			[158, 85, 54],
			[159, 45, 63],
			[160, 45, 53],
			[161, 60, 52],
			[162, 66, 51],
			[163, 82, 63]
		];
		foreach ($records as $record){
			DB::insert('insert into compagnonage_fonction (id, fonction_id, compagnonage_id) values (?, ?, ?)', $record);
		}
    }
}
