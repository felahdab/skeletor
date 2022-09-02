<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class CompagnonageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
            [22, 'PRODEF OPSC ', 'Compagnonnage PRODEF OPSC'],
            [21, 'PRODEF GN', 'Compagnonnage PROTEC GRADE NAVIRE'],
            [20, 'SOCLE', 'SOCLE'],
            [19, 'Comp OPSC', 'Compagnonnage OPSC'],
            [18, 'Comp OG', 'Compagnonnage Officier de Garde'],
            [17, 'Comp GE', 'Compagnonnage GRADE ELEC'],
            [23, 'Comp OPN', 'Compagnonnage OPN'],
            [24, 'Comp GP', 'Compagnonnage GRADE PONT'],
            [25, 'Comp GN', 'Compagnonnage GRADE NAVIRE'],
            [26, 'Comp GC', 'Compagnonnage GRADE COUPEE'],
            [27, 'OP EMBARCATION', 'OPERATEUR DE MISE A L\'EAU D\'EMBARCATION'],
            [28, 'SECU GSIC', 'SECU GRADE SIC'],
            [29, 'SECU GC', 'SECU GRADE COUPEE'],
            [30, 'SECU GE', 'SECU GRADE ELEC'],
            [31, 'SECU GP', 'SECU GRADE PONT'],
            [32, 'SECU GN', 'COMP SECU GRADE NAVIRE'],
            [33, 'SECU OPN', 'SECU OPN'],
            [34, 'SECU OPSC', 'SECU OPSC'],
            [35, 'LACH OPSC', 'Processus de lâcher OPSC'],
            [36, 'LACH OPN', 'Processus de lâcher OPN'],
            [37, 'LACH OG', 'Processus de lâcher OG'],
            [38, 'LACH GSIC', 'Processus de lâcher GRADE SIC'],
            [39, 'LACH GP', 'Processus de lâcher GRADE PONT'],
            [40, 'LACH GN', 'Processus de lâcher GRADE NAVIRE'],
            [41, 'LACH GE', 'Processus de lâcher GRADE ELEC'],
            [42, 'LACH GC', 'Processus de lâcher GRADE COUPEE'],
            [43, 'LACH GCMA', 'Processus de lâcher GRADE CMA'],
            [44, 'Comp AOQN', 'ADJOINT OQN MECAN'],
            [45, 'MECAN AIRE DE RAM', 'MECANICIEN AIRE DE RAM'],
            [46, 'MECAN EMBARCATION', 'MECAN EMBARCATION'],
            [47, 'MECAN DOCUMENTATION SID', 'MECAN DOCUMENTATION SID'],
            [48, 'Comp OQN', 'OFFICIER DE QUART NAVIRE'],
            [49, 'MECAN MAINT EXPERT', 'MAINTENANCIER SUP'],
            [50, 'MECAN MAINT ELEM', 'MAINTENANCIER ELEM MECAN'],
            [51, 'LAS GE MAINT ELEM', 'Compagnonnage Maint élémentaire GE'],
            [52, 'LAS GE MAINT EXPERT', 'Compagnonnage Maint expert GE'],
            [53, 'LAS GE OPERATEUR', 'COMP OPGE'],
            [54, 'LAS GE AGE', 'Compagnonnage AGE'],
            [55, 'LAS CROWN', 'COMP CROWN'],
            [56, 'LAS SURV - AIR', 'COMP SURV - AIR'],
            [57, 'LAS SDV', 'COMP SDV'],
            [58, 'LAS BUROPS', 'COMP BUROPS'],
            [59, 'LAS DEM MAINT ELEM', 'COMP DEM1'],
            [60, 'LAS DEM MAINT EXPERT', 'COMP DEM2'],
            [61, 'LAS SURV - SURF', 'COMP SURV -SURF'],
            [62, 'LAS OINFO', 'COMP OINFO'],
            [63, 'LAS MFC', 'COMP MFC'],
            [64, 'ELEC MAINT EXPERT ', 'MAINTENANCIER EXPERT ELECT'],
            [65, 'ELEC MAINT ELEM', 'Compagnonnage Maintenancier élémentaire électricité'],
            [66, 'ELEC OP-PROP-AUX', 'OPERATEUR PROPULSION AUXILIAIRE'],
            [67, 'ELEC CYBER', 'COMP CYBER ELEC'],
            [68, 'SECU MAINT ELEM', 'MAINTENANCIER ELEMENTAIRE SECURITE'],
            [70, 'SECU MAINT EXPERT ', 'MAINTENANCIER EXPERT SECURITE'],
            [71, 'SECU OP PORTE BORDEE', 'OPERATEUR PORTE DE BORDEE'],
            [72, 'LSM ARM', 'Maintenancier élémentaire ARM-LSM1'],
            [73, 'LSM CASM', 'COMPAGNONNAGE CASM'],
            [74, 'LSM OP SONAR', 'COMP OPERATEUR SONAR'],
            [75, 'LSM MAINT ELEM', 'Compagnonnage Maintenancier élémentaire LSM'],
            [76, 'LSM MAINT EXPERT', 'Compagnonnage Maintenancier EXPERT LSM'],
            [77, 'LAS CMS MAINT EXPERT', 'COMP CMS2'],
            [78, 'PONT - AOCDQ', 'ADJOINT DE QUART 1'],
            [79, 'PONT - OCDQ', 'OCDQ'],
            [80, 'PONT - EQ LIGNE', 'EQUIPIER LIGNE DE DISTANCE'],
            [81, 'PONT - EQ MAN', 'EQUIPIER PLAGE DE MANŒUVRE'],
            [82, 'PONT - PATRON D\'EMBARCATION', 'PATRON D\'EMBARCATION'],
            [83, 'PONT - DIR AIRE MAN', 'DIRECTEUR AIRE DE MANŒUVRE'],
            [84, 'PONT - MAN EXP', 'EXPERT MANŒUVRE'],
            [85, 'Comp GSIC', 'Compagnonnage GRADE SIC'],
            [86, 'SIC - ACSSI', 'FORMATION ACSSI'],
            [87, 'FCM - Anglais', 'FCM - Domaine 2 - anglais'],
            [88, 'FCM - Domaine 3 - GENOPS', 'FCM - Domaine 3 - GENOPS']

        ];
        foreach ($records as $record){
            DB::insert('insert into compagnonages (id, comp_libcourt, comp_liblong) values (?, ?, ?)', $record);
        }
    }
}
