<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

use App\Models\Stage;

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
            [4, 'Pas de licence', ''],
            [1, 'Licence 1', ''],
            [2, 'Licence 2', ''],
            [3, 'Licence 3', '']
        ];
        foreach ($records as $record){
            DB::insert('insert into type_licences (id, typlicense_libcourt, typlicense_liblong) values (?, ?, ?)', $record);
        }
        foreach (Stage::where('typelicence_id', 0)->get() as $stage)
        {
            $stage->typelicence_id = 4;
            $stage->save();
        }
    }
}
