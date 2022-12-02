<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class SpecialiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
            [1, 'GECOLL', 'Gérant de collectivité'],
            [2, 'COMLOG', 'Comptable-logisticien'],
            [3, 'GESTRH', 'Gestionnaire de personnel RH'],
            [4, 'ASCOM', 'Assistant du commandement'],
            [5, 'DETEC', 'Détecteur'],
            [6, 'DEASM', 'Détecteur anti-sous-marin'],
            [7, 'ELARM', 'Electronicien d armes'],
            [8, 'ELECT', 'Electrotechnicien'],
            [9, 'Equipage', 'Equipage'],
            [10, 'MEARM', 'Mécanicien d armes'],
            [11, 'MECAN', 'Mécanicien naval'],
            [12, 'ATNAV', 'Spécialiste d atelier naval'],
            [13, 'CONTA', 'Contrôleur d aéronautique'],
            [14, 'DENAE', 'Détecteur navigateur aérien'],
            [15, 'ELBOR', 'Electronicien de bord'],
            [16, 'MANAE', 'Manutention aéronautique'],
            [17, 'ARMAE', 'Spécialiste maintenance armement aéronautique'],
            [18, 'AVION', 'Spécialiste maintenance avionique aéronautique'],
            [19, 'PORTEUR', 'Spécialiste maintenance porteur aéronautique'],
            [20, 'MUSIF', 'Musicien de la flotte'],
            [21, 'PHOTAV', 'Photographe audiovisuel'],
            [22, 'SITEL', 'Spécialiste des systèmes d information et des télécommunications'],
            [23, 'COMMI', 'Commis aux vivres'],
            [24, 'CUISI', 'Cuisinier'],
            [25, 'MOTEL', 'Maître d hôtel'],
            [26, 'Vivres', 'Vivres'],
            [27, 'INFIR', 'Infirmier'],
            [28, 'FUSIL', 'Fusilier marin'],
            [29, 'MARPO', 'Marin pompier'],
            [30, 'MAPOM', 'Marin pompier de Marseille'],
            [31, 'PLONG', 'Plongeur démineur'],
            [32, 'SEGER', 'Service général'],
            [33, 'Moniteur de sport', 'Moniteur de sport'],
            [34, 'GUETF', 'Guetteur de la flotte'],
            [35, 'METEOC', 'Météorologiste-océanographe'],
            [36, 'MANEU', 'Manoeuvrier'],
            [37, 'NAVIT', 'Navigateur timonier'],
            [38, 'HYDRO', 'Hydrographe'],
            [39, 'COPS', 'Conduite des opérations'],
            [40, 'MISART', 'Missile-Artillerie'],
            [41, 'LSM', 'Lutte Sous la Mer'],
            [42, 'DET', 'Détecteur [Officier]'],
            [43, 'SIC', 'Systèmes d Information et de Commandement'],
            [44, 'ENERG', 'Energie propulsion'],
            [45, 'INFOG', 'Informatique générale'],
            [46, 'Sécurité', 'Sécurité'],
            [47, 'CCA', 'Contrôleur de la circulation aérienne'],
            [48, 'COA', 'Contrôleur des opérations aériennes'],
            [49, 'PILAE', 'Pilote d Aviation navale [sous contrat]'],
            [50, 'AVIAT', 'Pilote d Aviation navale [de carrière]'],
            [51, 'EOPAN', 'Elève officier pilote de l Aviation navale'],
            [52, 'AUTOPELEC', ''],
            [53, 'CDT', ''],
            [54, 'CYBER', ''],
            [55, 'ENV/PREV', ''],
            [56, 'MACHTHERM', ''],
            [57, 'MOBUREAU', ''],
            [58, 'MOMACH', ''],
            [59, 'MOPOMPI', ''],
            [60, 'MOPONT', ''],
            [61, 'MOPONTVOL', ''],
            [62, 'MORESTO', ''],
            [63, 'MOSDC', ''],
            [64, 'MOSIC', ''],
            [65, 'OPLSM', ''],
            [66, 'OPS', ''],
            [67, 'OPS AM', ''],
            [68, 'OPS ARM', ''],
            [69, 'OPS DEM', ''],
            [70, 'OPS DSM', ''],
            [71, 'OPS GE', ''],
            [72, 'OPS SAM', ''],
            [73, 'OPS SDC', ''],
            [74, 'RESTAU', ''],
            [75, 'SAM', ''],
            [76, 'SDC', ''],
            [77, 'SECIM', ''],
            [78, 'SECIT', ''],
            [79, 'TECHNOCOM', ''],
            [80, 'TECHOPS LSM', ''],
            [81, 'TECHSYR', ''],
            [82, 'AMOSIC', ''],
            [83, 'CLSM', ''],
            [84, 'CSD', ''],
            [85, 'ELECTRO', ''],
            [86, 'EPMS', ''],
            [87, 'HYDRAU', ''],
            [88, 'LOG', ''],
            [89, 'MECATRONIQUE', ''],
            [90, 'METOC', ''],
            [91, 'MORESTAU', ''],
            [92, 'OPERATIONS', ''],
            [93, 'SANSP', ''],
            [94, 'SCLAS', ''],
            [95, 'SCLSM', ''],
            [96, 'SCSIC', ''],
            [97, 'IETA', ''],
            [98, 'ARMES-EQUIPEMENT', ''],
            [99, 'MOMACHINE', ''],
            [100, 'SYNUM', ''],
            [101, 'RECOM', ''],
            [102, 'OPS/3D', ''],
            [103, 'OPS/DEM', ''],
            ];
        foreach ($records as $record){
            DB::insert('insert into specialites (id, specialite_libcourt, specialite_liblong) values (?, ?, ?)', $record);
        }
    }
}
