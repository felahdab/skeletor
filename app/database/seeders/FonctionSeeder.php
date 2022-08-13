<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class FonctionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
			[1, 'OG', 'Officier de Garde', 2, 1, 1],
			[2, 'OPSC', 'Officier ', 2, 1, 1],
			[3, 'OPN', 'Officier Pont Navire', 2, 1, 1],
			[4, 'GRADE NAVIRE', 'Gradé Navire', 2, 1, 1],
			[5, 'GRADE ELEC', 'Gradé électricité', 2, 1, 1],
			[6, 'GRADE PONT', 'Gradé Pont', 2, 1, 1],
			[7, 'GRADE COUPEE', 'Gradée Coupée', 2, 1, 1],
			[8, 'GRADE SIC', 'Gradé SIC', 2, 1, 1],
			[9, 'GRADE CMA', 'Gradé commissariat', 2, 1, 1],
			[10, 'OCDQ', 'Officier Chef De Quart', 1, 1, 1],
			[11, 'OAD', '', 1, 1, 0],
			[12, 'VEILLEUR', 'Veilleur', 1, 1, 1],
			[13, 'OQN', 'Officier de Quart Navire', 1, 1, 1],
			[14, 'MAINT ELEM SECU', 'Maintenance élémentaire sécurité', 3, 1, 0],
			[15, 'MAINT ELEM MECAN', 'Maintenance élémentaire mécanique', 3, 1, 0],
			[16, 'MAINT EXPERT COM', 'Maintenance supérieure communications', 3, 1, 0],
			[38, 'TIREUR 12 7MM', 'TIREUR 12 7MM et MINIGUN', 1, 1, 0],
			[39, 'SURV SDV', 'SURV SDV', 1, 1, 1],
			[40, 'SIC TRANS LO', 'SIC TRANS LO', 1, 1, 0],
			[41, 'SDCOM', 'SDCOM', 1, 1, 0],
			[42, 'PATRON EMBARCATION', 'PATRON EMBARCATION', 1, 1, 0],
			[43, 'OQA', 'OQA', 1, 1, 1],
			[44, 'OPSONAR', 'OPSONAR', 1, 1, 1],
			[45, 'OPGE', 'OPGE', 1, 1, 0],
			[46, 'OPER PORTE BORDEE', 'OPER PORTE DE BORDEE', 1, 1, 0],
			[47, 'OPER PROP AUX', 'OPER DE MISE EN ŒUVRE PROP AUX', 1, 1, 0],
			[48, 'OINFO', 'OINFO', 1, 1, 1],
			[49, 'MECAN EMBARCATION', 'MECAN EMBARCATION', 1, 1, 0],
			[50, 'MECAN AIRE DE RAM', 'MECAN AIRE DE RAM', 1, 1, 0],
			[51, 'MAINT EXPERT RES', 'MAINT EXPERT RESEAU', 3, 1, 0],
			[52, 'MAINT EXPERT MECAN', 'MAINT EXPERT MECAN', 3, 1, 0],
			[53, 'MAINT EXPERT MEARM', 'MAINT EXPERT MEARM', 3, 1, 0],
			[54, 'MAINT EXPERT SECU', 'MAINT EXPERT SECU', 3, 1, 0],
			[55, 'MAINT EXPERT ELEC', 'MAINT EXPERT ELEC', 3, 1, 0],
			[56, 'MAINT EXPERT DEM', 'MAINT EXPERT DEM', 3, 1, 0],
			[57, 'MAINT EXPERT CMS', 'MAINT EXPERT CMS', 3, 1, 0],
			[58, 'MAINT EXPERT MISSILE', 'MAINT EXPERT MISSILE', 3, 1, 0],
			[59, 'MAINT EXPERT LSM', 'MAINT EXPERT LSM', 3, 1, 0],
			[60, 'MAINT EXPERT GE', 'MAINT EXPERT GE', 3, 1, 0],
			[61, 'MAINT EXPERT AUDEF', 'MAINT EXPERT AUDEF', 3, 1, 0],
			[62, 'MAINT ELEM RES', 'MAINT ELEM RES', 3, 1, 0],
			[63, 'MAINT ELEM MISSILE', 'MAINT ELEM MISSILE', 3, 1, 0],
			[64, 'MAINT ELEM MEARM', 'MAINT ELEM MEARM', 3, 1, 0],
			[65, 'MAINT ELEM LSM', 'MAINT ELEM LSM', 3, 1, 0],
			[66, 'MAINT ELEM GE', 'MAINT ELEM GE', 3, 1, 0],
			[67, 'MAINT ELEM ELEC', 'MAINT ELEM ELEC', 3, 1, 0],
			[68, 'MAINT ELEM DEM', 'MAINT ELEM DEM', 3, 1, 0],
			[69, 'MAINT ELEM COM', 'MAINT ELEM COM', 3, 1, 0],
			[70, 'MAINT ELEM AUDEF', 'MAINT ELEM AUDEF', 3, 1, 0],
			[71, 'MAINT ELEM ARM LSM', 'MAINT ELEM ARM LSM', 3, 1, 0],
			[72, 'MAINT ARM LSM', 'MAINT ARM LSM', 3, 1, 0],
			[73, 'EXPERT MANŒUVRE', 'EXPERT MANŒUVRE', 1, 1, 0],
			[74, 'EQUIPIER PLAGE DE MANŒUVRE', 'EQUIPIER PLAGE DE MANŒUVRE', 1, 1, 0],
			[75, 'DIRECTEUR AIRE DE MANŒUVRE', 'DIRECTEUR AIRE DE MANŒUVRE', 1, 1, 0],
			[76, 'CTAC', 'CTAC', 1, 1, 1],
			[77, 'COMPTABLE ACSSI', 'COMPTABLE ACSSI', 1, 1, 0],
			[78, 'CHEF PC SEEIC', 'CHEF PC SEEIC', 1, 1, 0],
			[79, 'CHEF DE SOUTE GUNBAY', 'CHEF DE SOUTE GUNBAY', 1, 1, 0],
			[80, 'CHEF BUROPS', 'CHEF BUROPS', 1, 1, 0],
			[81, 'CDV', 'CDV', 1, 1, 0],
			[82, 'CASM', 'CASM', 1, 1, 1],
			[83, 'ASA 20 TO', 'ASA 20 TO', 1, 1, 0],
			[84, 'AOCDQ', 'AOCDQ', 1, 1, 1],
			[85, 'AGE', 'AGE', 1, 1, 0],
			[86, 'ADJOINT OQN MECAN', 'ADJOINT OQN MECAN', 1, 1, 1],
			[87, 'AAD', 'AAD', 1, 1, 0]
		];
		foreach ($records as $record){
			DB::insert('insert into fonctions (id, fonction_libcourt, fonction_liblong, typefonction_id, fonction_lache, fonction_double) values (?, ?, ?, ?, ?, ?)', $record);
		}
    }
}
