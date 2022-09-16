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
            [1,NULL,NULL,'OG','Officier de Garde',2,1,1],
            [2,NULL,'2022-09-08 08:45:24','OPSC','Officier Permanence Service Courant',2,1,1],
            [3,NULL,'2022-09-14 14:09:15','OPN','Officier Permanence Navire',2,1,1],
            [4,NULL,NULL,'GRADE NAVIRE','Gradé Navire',2,1,1],
            [5,NULL,NULL,'GRADE ELEC','Gradé électricité',2,1,1],
            [6,NULL,NULL,'GRADE PONT','Gradé Pont',2,1,1],
            [7,NULL,'2022-09-07 11:41:03','GRADE COUPEE','Gradé Coupée',2,1,1],
            [8,NULL,NULL,'GRADE SIC','Gradé SIC',2,1,1],
            [9,NULL,NULL,'GRADE CMA','Gradé commissariat',2,1,1],
            [10,NULL,'2022-09-15 12:05:01','PONT OCDQ','Officier Chef De Quart',1,1,1],
            [11,NULL,'2022-09-14 14:27:36','ARM OAD','Officier Auto Défense - Système d\'Armes',3,1,1],
            [12,NULL,'2022-09-14 14:26:12','ARM VEILLEUR','Veilleur',3,1,1],
            [13,NULL,'2022-09-14 14:17:06','MECAN OQN','Officier de Quart Navire',3,1,1],
            [14,NULL,'2022-09-14 14:26:45','MAINT ELEM SECU','MAINTENANCE ELEMENTAIRE SECURITE',3,1,1],
            [15,NULL,'2022-09-14 14:26:46','MAINT ELEM MECAN FLOT','MAINTENANCE ELEMENTAIRE MECAN FLOTTEUR',3,1,1],
            [16,NULL,'2022-09-15 11:59:09','SIC MAINT SUP RECOM','MAINTENANCE SUPERIEUR RECOM',3,1,1],
            [38,NULL,'2022-09-14 14:17:24','ARM TIREUR 12 7MM','TIREUR 12 7MM et MINIGUN',3,1,1],
            [39,NULL,'2022-09-14 14:17:36','LAS SURV SDV','SURV SDV',3,1,1],
            [40,NULL,'2022-09-12 12:01:36','SIC TRANS LO','SIC TRANS LO',3,1,1],
            [41,NULL,'2022-09-14 14:17:48','SIC SDCOM','SDCOM',3,1,1],
            [42,NULL,'2022-09-14 14:18:01','PONT PATRON EMBARCATION','PATRON EMBARCATION',3,1,1],
            [43,NULL,'2022-09-14 14:18:16','PONT OQA','Officier de Quart Aviation',3,1,1],
            [44,NULL,'2022-09-14 14:18:22','LSM OPSONAR BAT','Opérateur Sonar BAT',3,1,1],
            [45,NULL,'2022-09-14 14:18:39','LAS OPGE','OPGE',3,1,1],
            [46,NULL,'2022-09-15 14:38:58','SECU OPER PORTE BORDEE','Opérateur Porte de Bordée',1,1,1],
            [47,NULL,'2022-09-14 14:19:29','ELEC OPER PROP AUX','Opérateur Propulsion Auxiliaire',3,1,1],
            [48,NULL,'2022-09-14 14:19:40','LAS OINFO','OINFO',3,1,1],
            [49,NULL,'2022-09-12 11:47:24','MECAN EMBARCATION','MECAN EMBARCATION',3,1,1],
            [50,NULL,'2022-09-12 11:47:28','MECAN AIRE DE RAM','MECAN AIRE DE RAM',3,1,1],
            [51,NULL,'2022-09-15 11:57:18','SIC MAINT SUP SYNUM','MAINTENANCE SUPERIEURE SYNUM',3,1,1],
            [52,NULL,'2022-09-14 14:20:57','MAINT EXPERT MECAN FLOT','MAINTENANCE EXPERT MECAN FLOTTEUR',3,1,1],
            [53,NULL,'2022-09-14 14:20:52','MAINT EXPERT MEARM','MAINTENANCE EXPERT MEARM',3,1,1],
            [54,NULL,'2022-09-14 14:20:50','MAINT EXPERT SECU','MAINTENANCE EXPERT SECURITE',3,1,1],
            [55,NULL,'2022-09-14 14:20:48','MAINT EXPERT ELECT','MAINTENANCE EXPERT ELECTRICITE',3,1,1],
            [56,NULL,'2022-09-14 14:20:46','MAINT EXPERT DEM','MAINTENANCE EXPERT DEM',3,1,1],
            [57,NULL,'2022-09-14 14:21:13','MAINT EXPERT CMS','MAINTENANCE EXPERT CMS',3,1,1],
            [58,NULL,'2022-09-15 11:50:01','ARM MAINT EXPERT MISSILE','MAINTENANCE EXPERT MISSILE',3,1,1],
            [59,NULL,'2022-09-14 14:21:22','MAINT EXPERT LSM','MAINTENANCE EXPERT LSM',3,1,1],
            [60,NULL,'2022-09-14 14:21:28','MAINT EXPERT GE','MAINTENANCE EXPERT GE',3,1,1],
            [61,NULL,'2022-09-15 11:51:21','ARM MAINT EXPERT AUDEF','MAINTENANCE EXPERT AUDEF',3,1,1],
            [62,NULL,'2022-09-15 11:57:16','SIC MAINT ELEM SYNUM','MAINTENANCE ELEMENTAIRE SYNUM',3,1,1],
            [63,NULL,'2022-09-15 11:50:00','ARM MAINT ELEM MISSILE','MAINTENANCE ELEMENTAIRE MISSILE',3,1,1],
            [64,NULL,'2022-09-14 14:23:03','MAINT ELEM MEARM','MAINTENANCE ELEMENTAIRE MEARM',3,1,1],
            [65,NULL,'2022-09-14 14:23:05','MAINT ELEM LSM','MAINTENANCE ELEMENTAIRE LSM',3,1,1],
            [66,NULL,'2022-09-14 14:23:08','MAINT ELEM GE','MAINTENANCE ELEMENTAIRE GE',3,1,1],
            [67,NULL,'2022-09-14 14:23:11','MAINT ELEM ELEC','MAINTENANCE ELEMENTAIRE ELEC',3,1,1],
            [68,NULL,'2022-09-14 14:23:15','MAINT ELEM DEM','MAINTENANCE ELEMENTAIRE DEM',3,1,1],
            [69,NULL,'2022-09-15 11:59:07','SIC MAINT ELEM RECOM','MAINTENANCE ELEMENTAIRE RECOM',3,1,1],
            [70,NULL,'2022-09-15 11:51:19','ARM MAINT ELEM AUDEF','MAINTENANCE ELEMENTAIRE AUDEF',3,1,1],
            [71,NULL,'2022-09-14 14:23:25','MAINT ELEM ARM LSM','MAINTENANCE ELEMENTAIRE ARM LSM',3,1,1],
            [72,NULL,'2022-09-14 14:29:10','MAINT EXPERT ARM LSM','MAINTENANCE EXPERT ARM LSM',3,1,1],
            [73,NULL,'2022-09-14 13:44:12','PONT EXP MANŒUVRE','EXPERT MANŒUVRE',3,1,1],
            [74,NULL,'2022-09-14 13:45:50','PONT EQ MANŒUVRE','EQUIPIER PLAGE DE MANŒUVRE',3,1,1],
            [75,NULL,'2022-09-14 13:46:33','PONT DIR MANŒUVRE','DIRECTEUR AIRE DE MANŒUVRE',3,1,1],
            [76,NULL,'2022-09-14 14:24:24','PONT CTAC','CTAC',3,1,1],
            [79,NULL,'2022-09-14 14:24:36','ARM CHEF DE SOUTE GUNBAY','CHEF DE SOUTE GUNBAY',3,1,1],
            [80,NULL,'2022-09-14 14:24:49','LAS CHEF BUROPS','CHEF BUROPS',3,1,1],
            [81,NULL,'2022-09-14 13:51:38','ARM CDV','CDV',3,1,1],
            [82,NULL,'2022-09-14 13:51:27','LSM CASM','CASM',1,1,1],
            [83,NULL,'2022-09-15 11:52:35','ARM ASA 20 TO','ASA 20 TO',3,1,1],
            [84,NULL,'2022-09-14 13:52:27','PONT AOCDQ','Adjoint Officier Chef de Quart',1,1,1],
            [85,NULL,'2022-09-14 13:53:54','LAS AGE','AGE',3,1,1],
            [86,NULL,'2022-09-14 13:54:33','MECAN AOQN','ADJOINT OFFICIER DE QUART NAVIRE',3,1,1],
            [87,NULL,'2022-09-14 13:57:33','ARM AAD','ADJOINT AUTO DEFENSE',3,1,1],
            [88,NULL,'2022-09-14 14:25:04','MAINT ELEM MECAN MOB','MAINTENANCE ELEMENTAIRE MECAN MOBILITE',3,1,1],
            [89,NULL,'2022-09-14 14:25:40','MAINT EXPERT MECAN MOB','MAINTENANCE EXPERT MECAN MOBILITE',3,1,1],
            [90,NULL,'2022-09-15 11:46:40','LSM OPSONAR MOOPS','OPSONAR MOOPS',3,1,1],
            [99,'2022-09-14 12:20:48','2022-09-15 11:59:06','SIC MAINT EXP RECOM','MAINTENANCE EXPERT RECOM',0,0,0],
            [100,'2022-09-14 12:52:06','2022-09-15 11:57:15','SIC MAINT EXP SYNUM','MAINTENANCE EXPERT SYNUM',0,0,0],
            [101,'2022-09-14 14:12:11','2022-09-14 14:25:29','ARM MAINT ELEM MOMACH','MAINTENANCE ELEMENTAIRE MOMACH',3,1,1],
            [102,'2022-09-14 14:14:13','2022-09-14 14:14:21','PONT EQ PEH','EQUIPIER PEH',3,1,1],
            [104,'2022-09-15 14:05:57','2022-09-15 14:08:49','FCM-LSM OPSONAR DSM/SURF','FCM - OPERATEUR SONAR',0,0,0]
        ];
        foreach ($records as $record){
            DB::insert('insert into fonctions (id, created_at, updated_at, fonction_libcourt, fonction_liblong, typefonction_id, fonction_lache, fonction_double) values (?, ?, ?, ?, ?, ?, ?, ?)', $record);
        }
    }
}
