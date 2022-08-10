<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class StageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
			[1, '00-1', '', 0, 2],
			[2, '12.7MM MAINT', 'toto\'test', 1, 2],
			[3, '12.7MM MOE', '', 0, 0],
			[4, '20 MM-TO-NARWHAL', '', 0, 0],
			[5, '76 MM-1', '', 0, 3],
			[6, '76 MM-2', '', 0, 3],
			[7, 'ACTUNRBC', '', 0, 0],
			[8, 'ADMINLINUX', '', 0, 0],
			[9, 'ADMINSIA BOX CD', '', 0, 0],
			[10, 'ADMINWINSERVER', '', 0, 0],
			[11, 'ANALYSE CARBUREACTEUR', '', 0, 0],
			[12, 'ANIM-BT', '', 0, 1],
			[13, 'ANIMATEUR-CONCEPTEUR', '', 1, 0],
			[14, 'APTE ANAVIAB', '', 0, 0],
			[15, 'APTE B1V', '', 1, 1],
			[16, 'APTE BATTERIES', '', 0, 0],
			[17, 'APTE HE MANŒUVRE', '', 0, 0],
			[18, 'APTE HT', '', 0, 0],
			[19, 'APTE MANELEC', '', 0, 0],
			[20, 'ARISTOTE', '', 0, 0],
			[21, 'ARMINF MOE', '', 0, 0],
			[22, 'ASA MdCN', '', 0, 0],
			[23, 'AUXI-1', '', 0, 3],
			[24, 'BT-H0V', '', 0, 0],
			[25, 'C CLASBRUIT', '', 0, 0],
			[26, 'C-PC-SIC', '', 0, 0],
			[27, 'CML1 Anglais', '', 1, 0],
			[28, 'CML1 Espagnol', '', 1, 0],
			[29, 'CML1 Italien', '', 1, 0],
			[30, 'CML2 Anglais', '', 1, 0],
			[31, 'CMS-FREMM', '', 0, 0],
			[32, 'COMCEPT', '', 0, 0],
			[33, 'COMPAGNONAGE SECU GRADE PONT', '', 0, 0],
			[34, 'CONCEPTEUR RESEAU LDT', '', 0, 0],
			[35, 'CONTARNEF [= CTAC]', '', 0, 0],
			[36, 'CSI-ADMINCSI', '', 0, 0],
			[37, 'DEFENSEAVUE', '', 0, 0],
			[38, 'EA/ME-2', '', 0, 0],
			[39, 'ECOU', '', 0, 0],
			[40, 'ED-1', '', 0, 0],
			[41, 'ED/MT/MO-2', '', 0, 0],
			[42, 'ELAB-TMA', '', 0, 0],
			[43, 'EQUINAV-2', '', 0, 0],
			[44, 'EWS-FREMM', '', 0, 0],
			[45, 'F/EDCH ', 'analyse eau destination conso humaine', 0, 0],
			[46, 'FIBRE-OPTIQUE', '', 0, 0],
			[47, 'FRIGO LONG', 'FROID LONG', 0, 0],
			[48, 'HE MANŒUVRE', '', 0, 0],
			[49, 'HERAKLES', '', 0, 0],
			[50, 'HORS-BORD', '', 0, 0],
			[51, 'HT', '', 0, 0],
			[52, 'ILSM FREMM-1', '', 0, 0],
			[53, 'ILSM-2', '', 0, 0],
			[54, 'INITOUR', '', 0, 0],
			[55, 'INTRADEF EMBARQUE', '', 0, 0],
			[56, 'INVESTIGATION', '', 0, 0],
			[57, 'INVESTNRBC', '', 0, 0],
			[58, 'IPBX', '', 0, 0],
			[59, 'ISS FREMM-1', '', 0, 0],
			[60, 'ISS-CASM', '', 0, 0],
			[61, 'L22', '', 0, 0],
			[62, 'MAGIC', '', 0, 0],
			[63, 'MANUTEN', '', 0, 0],
			[64, 'MCO EDO', '', 0, 0],
			[65, 'MDCN-LANCEUR', '', 0, 0],
			[66, 'ME-1', '', 0, 0],
			[67, 'MESURE VIB', '', 0, 0],
			[68, 'MINIGUN MAINT', '', 0, 0],
			[69, 'MINIGUN MOE', '', 0, 0],
			[70, 'MODEM XXI', '', 0, 0],
			[71, 'MOPAS', 'opérateur Audio-spectral', 0, 0],
			[72, 'MT-1', '', 0, 0],
			[73, 'N/NGC', 'SITS 2ème partie pratique SYRACUSE III', 0, 0],
			[74, 'NAJIR MM', '', 0, 0],
			[75, 'NAVR 1-2', '', 0, 0],
			[76, 'NLNG', 'SITS 2ème partie pratique SYRACUSE IV', 0, 0],
			[77, 'OAD FREMM', '', 0, 0],
			[78, 'OMAR HF EXPLOIT', '', 0, 0],
			[79, 'OMAR HF TECH', '', 0, 0],
			[80, 'OO-2', '', 0, 0],
			[81, 'OPELINT BAT', '', 0, 0],
			[82, 'OPERUNIXILINUX', '', 0, 0],
			[83, 'PCE PACSS', '', 0, 0],
			[84, 'PCE SATANAS', '', 0, 0],
			[85, 'PEMP', 'plates-formes élévatrices mobiles de personnel', 1, 0],
			[86, 'PR4G', '', 0, 0],
			[87, 'PREPMISS-PORTEUR-MDCN', '', 0, 0],
			[88, 'PREVENTION', '', 1, 0],
			[89, 'QB-1', '', 0, 0],
			[90, 'QB-2', '', 0, 0],
			[91, 'QI-1', '', 0, 0],
			[92, 'QPDS 1-2', '', 0, 0],
			[93, 'RADEF', '', 0, 0],
			[94, 'Recyclage BT-H0V', '', 0, 0],
			[95, 'Recyclage HT', '', 0, 0],
			[96, 'Règlement chiffre', '', 0, 0],
			[97, 'RIFAN2-ADMIN-NOC-SOC', '', 0, 0],
			[98, 'RIFAN2-EXPLOIT BORD', '', 0, 0],
			[99, 'SASDECONTA', '', 0, 0],
			[100, 'SECU-1', '', 0, 0],
			[101, 'SELTIC-EXPLOIT DTC', '', 0, 0],
			[102, 'SELTIC-EXPLOIT LOCAL', '', 0, 0],
			[103, 'SERBAR 76MM', '', 0, 0],
			[104, 'SIC 21 ADMIN LOC', '', 0, 0],
			[105, 'SIC21-OPERMMOPS', '', 0, 0],
			[106, 'SMDSM', '', 0, 0],
			[107, 'SOUD1', '', 1, 0],
			[108, 'SOUD2', '', 1, 0],
			[109, 'SYLVER-1', '', 0, 0],
			[110, 'SYLVER-2', '', 0, 0],
			[111, 'TH SAT', '', 0, 0],
			[112, 'THERMOGRAPHIE', '', 0, 0],
			[113, 'TOURNEUR', '', 1, 0],
			[114, 'TST BATTERIE', '', 0, 0],
			[115, 'TUYAUTEUR', '', 0, 0],
			[116, 'TVSATNUM', '', 0, 0],
			[117, 'VSAT M', '', 0, 0],
			[119, 'stage test', '', 0, 0],
			[120, 'stage de test transverse et licence 1', '', 1, 1]
		];
		foreach ($records as $record){
			DB::insert('insert into stages (id, stage_libcourt, stage_liblong, transverse, typelicence_id) values (?, ?, ?, ?, ?)', $record);
		}
    }
}
