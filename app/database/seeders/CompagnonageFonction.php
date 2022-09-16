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
       [92,NULL,NULL,20,7],
[93,NULL,NULL,26,7],
[94,NULL,NULL,29,7],
[95,NULL,NULL,20,8],
[96,NULL,NULL,28,8],
[97,NULL,NULL,38,8],
[98,NULL,NULL,20,6],
[99,NULL,NULL,24,6],
[100,NULL,NULL,31,6],
[101,NULL,NULL,39,6],
[102,NULL,NULL,20,5],
[104,NULL,NULL,17,5],
[105,NULL,NULL,30,5],
[107,NULL,NULL,41,5],
[108,NULL,NULL,20,4],
[109,NULL,NULL,21,4],
[110,NULL,NULL,32,4],
[111,NULL,NULL,25,4],
[112,NULL,NULL,71,4],
[113,NULL,NULL,40,4],
[114,NULL,NULL,20,3],
[115,NULL,NULL,33,3],
[116,NULL,NULL,23,3],
[117,NULL,NULL,36,3],
[118,NULL,NULL,20,2],
[119,NULL,NULL,22,2],
[120,NULL,NULL,34,2],
[121,NULL,NULL,19,2],
[122,NULL,NULL,35,2],
[123,NULL,NULL,20,1],
[124,NULL,NULL,18,1],
[125,NULL,NULL,37,1],
[126,NULL,NULL,70,54],
[127,NULL,NULL,68,14],
[128,NULL,NULL,71,46],
[129,NULL,NULL,64,55],
[130,NULL,NULL,67,55],
[131,NULL,NULL,65,67],
[132,NULL,NULL,67,67],
[133,NULL,NULL,66,47],
[134,NULL,NULL,49,52],
[135,NULL,NULL,50,15],
[136,NULL,NULL,47,13],
[137,NULL,NULL,48,13],
[139,NULL,NULL,44,86],
[140,NULL,NULL,46,49],
[141,NULL,NULL,45,50],
[142,NULL,NULL,63,80],
[147,NULL,NULL,61,39],
[148,NULL,NULL,56,39],
[149,NULL,NULL,57,39],
[150,NULL,NULL,58,80],
[151,NULL,NULL,63,48],
[152,NULL,NULL,62,48],
[153,NULL,NULL,57,48],
[154,NULL,NULL,58,48],
[155,NULL,NULL,60,56],
[156,NULL,NULL,59,68],
[157,NULL,NULL,63,85],
[158,NULL,NULL,54,85],
[159,NULL,NULL,63,45],
[160,NULL,NULL,53,45],
[161,NULL,NULL,52,60],
[162,NULL,NULL,51,66],
[163,NULL,NULL,63,82],
[164,NULL,NULL,49,89],
[165,NULL,NULL,50,88],
[166,NULL,NULL,74,44],
[168,NULL,NULL,20,9],
[169,NULL,NULL,43,9],
[170,NULL,NULL,55,76],
[171,NULL,NULL,72,71],
[172,NULL,NULL,75,65],
[173,NULL,NULL,76,59],
[174,NULL,NULL,77,57],
[175,NULL,NULL,78,84],
[176,NULL,NULL,79,10],
[177,NULL,NULL,80,11],
[178,NULL,NULL,80,81],
[179,NULL,NULL,80,12],
[180,NULL,NULL,81,87],
[181,NULL,NULL,81,74],
[183,NULL,NULL,81,44],
[184,NULL,NULL,81,12],
[185,NULL,NULL,82,42],
[186,NULL,NULL,83,75],
[187,NULL,NULL,84,73],
[188,NULL,NULL,85,8],
[190,NULL,NULL,87,91],
[192,NULL,NULL,88,91],
[193,'2022-09-07 11:30:28','2022-09-07 11:30:28',71,5],
[194,'2022-09-07 11:41:35','2022-09-07 11:41:35',42,7],
[195,'2022-09-09 05:54:51','2022-09-09 05:54:51',63,44],
[196,'2022-09-09 06:57:11','2022-09-09 06:57:11',72,72],
[197,'2022-09-09 07:00:46','2022-09-09 07:00:46',73,82],
[199,'2022-09-09 09:37:51','2022-09-09 09:37:51',89,40],
[200,'2022-09-12 07:12:09','2022-09-12 07:12:09',90,43],
[201,'2022-09-12 07:18:55','2022-09-12 07:18:55',91,76],
[202,'2022-09-12 07:51:28','2022-09-12 07:51:28',92,71],
[203,'2022-09-12 08:08:20','2022-09-12 08:08:20',93,71],
[204,'2022-09-12 08:37:44','2022-09-12 08:37:44',94,71],
[205,'2022-09-12 10:56:12','2022-09-12 10:56:12',86,16],
[206,'2022-09-12 13:17:35','2022-09-12 13:17:35',95,11],
[207,'2022-09-12 13:42:01','2022-09-12 13:42:01',96,11],
[208,'2022-09-12 14:01:02','2022-09-12 14:01:02',97,11],
[209,'2022-09-12 14:17:55','2022-09-12 14:17:55',98,11],
[210,'2022-09-12 14:32:36','2022-09-12 14:32:36',98,87],
[211,'2022-09-12 14:32:46','2022-09-12 14:32:46',96,87],
[212,'2022-09-12 14:33:09','2022-09-12 14:33:09',56,87],
[213,'2022-09-13 08:22:59','2022-09-13 08:22:59',99,87],
[214,'2022-09-13 08:29:27','2022-09-13 08:29:27',100,87],
[215,'2022-09-13 09:40:51','2022-09-13 09:40:51',101,41],
[216,'2022-09-13 10:17:38','2022-09-13 10:17:38',102,62],
[217,'2022-09-13 11:24:06','2022-09-13 11:24:06',103,69],
[218,'2022-09-13 11:57:30','2022-09-13 11:57:30',104,51],
[219,'2022-09-13 12:07:36','2022-09-13 12:07:36',105,16],
[220,'2022-09-13 13:49:17','2022-09-13 13:49:17',106,58],
[222,'2022-09-13 13:52:32','2022-09-13 13:52:32',108,83],
[223,'2022-09-13 13:52:48','2022-09-13 13:52:48',107,58],
[224,'2022-09-14 08:45:15','2022-09-14 08:45:15',92,61],
[225,'2022-09-14 08:45:24','2022-09-14 08:45:24',98,61],
[226,'2022-09-14 08:45:33','2022-09-14 08:45:33',109,61],
[227,'2022-09-14 08:47:02','2022-09-14 08:47:02',96,12],
[228,'2022-09-14 08:47:18','2022-09-14 08:47:18',92,12],
[229,'2022-09-14 08:47:58','2022-09-14 08:47:58',93,12],
[230,'2022-09-14 08:52:05','2022-09-14 08:52:05',94,38],
[231,'2022-09-14 09:18:04','2022-09-14 09:18:04',110,63],
[232,'2022-09-14 09:18:11','2022-09-14 09:18:11',111,63],
[233,'2022-09-14 09:39:49','2022-09-14 09:39:49',96,81],
[234,'2022-09-14 09:39:57','2022-09-14 09:39:57',92,81],
[235,'2022-09-14 09:40:05','2022-09-14 09:40:05',112,81],
[236,'2022-09-14 09:40:12','2022-09-14 09:40:12',100,81],
[237,'2022-09-14 10:15:01','2022-09-14 10:15:01',114,70],
[238,'2022-09-14 10:15:07','2022-09-14 10:15:07',110,70],
[239,'2022-09-14 10:15:15','2022-09-14 10:15:15',113,70],
[240,'2022-09-14 10:15:29','2022-09-14 10:15:29',111,70],
[241,'2022-09-14 10:51:58','2022-09-14 10:51:58',115,64],
[242,'2022-09-14 11:24:21','2022-09-14 11:24:21',116,53],
[243,'2022-09-14 11:45:23','2022-09-14 11:45:23',117,79],
[244,'2022-09-14 12:25:01','2022-09-14 12:25:01',105,99],
[245,'2022-09-14 12:43:55','2022-09-14 12:43:55',81,45],
[246,'2022-09-14 12:52:23','2022-09-14 12:52:23',104,100],
[247,'2022-09-14 14:06:35','2022-09-14 14:06:35',74,90],
[248,'2022-09-14 14:06:49','2022-09-14 14:06:49',81,90],
[249,'2022-09-14 14:12:33','2022-09-14 14:12:33',94,101],
[250,'2022-09-15 14:01:37','2022-09-15 14:01:37',113,103],
[253,'2022-09-15 14:28:58','2022-09-15 14:28:58',119,104]
        ];
        foreach ($records as $record){
            DB::insert('insert into compagnonage_fonction (id, created_at, updated_at, compagnonage_id, fonction_id) values (?, ?, ?, ?, ?)', $record);
        }
    }
}
