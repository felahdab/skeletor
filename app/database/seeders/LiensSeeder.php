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
            [1, 'WikiFREMM', 'https://wiki-gtr-brest.intradef.gouv.fr/doku.php?id=Accueil', 'wikiFREMM.png'],
            [2, 'GTR/T', 'https://portail-gtr-toulon.intradef.gouv.fr/index.php', 'gtr-toulon.png'],
            [3, 'GTR/B', 'http://portail-gtr-brest.marine.defense.gouv.fr/', 'gtr-brest.png'],
            [4, 'IP', 'https://wiki-gtr-brest.intradef.gouv.fr/doku.php?id=00-page_de_garde:instructions_permanentes', 'InsigneEscouade.jpg'],
            [5, 'FREMM360', 'http://pem-form.intradef.gouv.fr/atrium/Vv_Fremm/vvirtuelle.html', 'fremm360.png'],
            ];
        foreach ($records as $record){
            DB::insert('insert into liens (id, lien_lib, lien_url, lien_image) values (?, ?, ?, ?)', $record);
        }
    }
}
