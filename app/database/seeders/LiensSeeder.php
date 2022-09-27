<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class LiensSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
            [1, 'WikiFREMM', 'https://wiki-gtr-brest.intradef.gouv.fr/doku.php?id=Accueil', 'a voir',2],
            [2, 'GTR/T', 'https://portail-gtr-toulon.intradef.gouv.fr/index.php', 'a voir',2],
            [3, 'IP', 'https://wiki-gtr-brest.intradef.gouv.fr/doku.php?id=00-page_de_garde:instructions_permanentes', 'a voir',2],
            [4, 'FREMM360', 'http://pem-form.intradef.gouv.fr/atrium/Vv_Fremm/vvirtuelle.html', 'a voir',2],
            [5, 'WikiFREMM', 'https://wiki-gtr-brest.intradef.gouv.fr/doku.php?id=Accueil', 'a voir',1],
            [6, 'FREMM360', 'http://pem-form.intradef.gouv.fr/atrium/Vv_Fremm/vvirtuelle.html', 'a voir',1],
            ];
        foreach ($records as $record){
            DB::insert('insert into liens (id, lien_lib, lien_url, lien_image ,unite_id) values (?, ?, ?, ?, ?)', $record);
        }
    }
}
