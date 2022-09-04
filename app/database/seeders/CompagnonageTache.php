<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class CompagnonageTache extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
            [24, 18, 18],
            [23, 18, 17],
            [22, 18, 16],
            [21, 17, 15],
            [20, 17, 14],
            [19, 17, 12],
            [18, 17, 13],
            [25, 18, 19],
            [26, 18, 20],
            [27, 18, 21],
            [28, 18, 22],
            [29, 18, 23],
            [30, 19, 32],
            [31, 19, 31],
            [32, 19, 30],
            [33, 21, 35],
            [34, 24, 46],
            [35, 24, 47],
            [36, 20, 34],
            [37, 20, 33],
            [38, 23, 40],
            [39, 23, 38],
            [40, 23, 39],
            [41, 23, 45],
            [42, 23, 42],
            [43, 23, 44],
            [44, 23, 41],
            [45, 23, 37],
            [46, 23, 43],
            [47, 22, 36],
            [48, 25, 48],
            [49, 25, 49],
            [50, 25, 50],
            [51, 25, 51],
            [52, 25, 52],
            [53, 25, 53],
            [54, 25, 54],
            [55, 25, 55],
            [56, 26, 56],
            [57, 26, 58],
            [58, 26, 57],
            [59, 27, 60],
            [60, 27, 59],
            [61, 28, 61],
            [62, 28, 62],
            [63, 28, 63],
            [64, 29, 66],
            [65, 29, 62],
            [66, 29, 65],
            [67, 29, 63],
            [68, 29, 64],
            [69, 30, 67],
            [70, 30, 68],
            [71, 30, 69],
            [72, 30, 70],
            [73, 30, 71],
            [74, 30, 72],
            [75, 30, 73],
            [76, 30, 74],
            [77, 30, 75],
            [78, 30, 76],
            [79, 30, 77],
            [80, 30, 78],
            [81, 30, 79],
            [82, 31, 81],
            [83, 31, 80],
            [84, 31, 83],
            [85, 31, 84],
            [86, 31, 82],
            [87, 32, 85],
            [88, 33, 86],
            [89, 33, 87],
            [90, 33, 88],
            [91, 33, 90],
            [92, 33, 91],
            [93, 33, 89],
            [94, 34, 92],
            [95, 34, 93],
            [96, 34, 94],
            [97, 35, 95],
            [98, 36, 96],
            [99, 37, 97],
            [100, 38, 98],
            [101, 39, 99],
            [102, 40, 100],
            [103, 41, 101],
            [104, 42, 102],
            [105, 43, 103],
            [106, 44, 104],
            [107, 44, 105],
            [108, 44, 106],
            [109, 44, 107],
            [110, 44, 108],
            [111, 44, 112],
            [112, 44, 110],
            [113, 44, 111],
            [114, 45, 113],
            [115, 46, 114],
            [116, 46, 115],
            [117, 47, 116],
            [118, 48, 117],
            [119, 48, 118],
            [120, 48, 119],
            [121, 48, 120],
            [122, 48, 121],
            [123, 48, 122],
            [124, 48, 123],
            [125, 48, 124],
            [126, 48, 125],
            [127, 49, 127],
            [128, 49, 126],
            [129, 50, 128],
            [130, 51, 129],
            [131, 52, 130],
            [132, 52, 131],
            [133, 52, 132],
            [134, 52, 133],
            [135, 53, 134],
            [136, 53, 135],
            [137, 53, 136],
            [138, 53, 137],
            [139, 53, 138],
            [140, 53, 139],
            [141, 53, 140],
            [142, 53, 141],
            [143, 53, 142],
            [144, 53, 143],
            [145, 53, 144],
            [146, 53, 145],
            [147, 53, 146],
            [148, 54, 147],
            [149, 54, 148],
            [150, 54, 149],
            [151, 54, 150],
            [152, 54, 152],
            [153, 54, 153],
            [154, 54, 154],
            [155, 54, 155],
            [156, 54, 136],
            [157, 54, 137],
            [158, 54, 158],
            [159, 54, 159],
            [160, 54, 138],
            [161, 54, 141],
            [162, 54, 142],
            [163, 55, 160],
            [164, 55, 161],
            [165, 55, 162],
            [166, 55, 163],
            [167, 55, 164],
            [168, 56, 165],
            [169, 56, 166],
            [170, 56, 167],
            [171, 56, 168],
            [172, 56, 169],
            [173, 57, 170],
            [174, 57, 171],
            [175, 57, 172],
            [176, 57, 173],
            [177, 57, 174],
            [178, 58, 175],
            [179, 58, 176],
            [180, 58, 177],
            [181, 58, 178],
            [182, 58, 179],
            [183, 59, 180],
            [184, 60, 181],
            [185, 60, 182],
            [186, 60, 183],
            [187, 60, 184],
            [188, 61, 185],
            [189, 61, 186],
            [190, 61, 187],
            [191, 61, 188],
            [192, 61, 190],
            [193, 61, 191],
            [194, 61, 192],
            [195, 61, 193],
            [196, 62, 194],
            [197, 62, 195],
            [198, 62, 196],
            [199, 62, 197],
            [200, 62, 198],
            [201, 62, 199],
            [202, 62, 200],
            [203, 62, 201],
            [204, 62, 202],
            [205, 61, 189],
            [206, 63, 203],
            [207, 64, 204],
            [208, 64, 205],
            [209, 64, 206],
            [210, 64, 207],
            [211, 64, 208],
            [212, 65, 209],
            [213, 65, 210],
            [214, 65, 211],
            [215, 65, 212],
            [216, 65, 213],
            [217, 65, 214],
            [218, 65, 215],
            [219, 65, 216],
            [220, 65, 217],
            [221, 65, 218],
            [222, 65, 219],
            [223, 66, 220],
            [224, 67, 221],
            [225, 68, 222],
            [226, 70, 223],
            [227, 70, 224],
            [228, 70, 225],
            [229, 70, 226],
            [230, 71, 227],
            [231, 72, 228],
            [232, 72, 229],
            [233, 72, 230],
            [234, 73, 231],
            [235, 73, 232],
            [236, 73, 233],
            [237, 73, 234],
            [238, 73, 235],
            [239, 73, 236],
            [240, 73, 237],
            [241, 73, 238],
            [242, 73, 239],
            [243, 73, 240],
            [244, 73, 241],
            [245, 73, 242],
            [246, 73, 243],
            [247, 74, 244],
            [248, 74, 245],
            [249, 74, 246],
            [250, 74, 247],
            [251, 74, 248],
            [252, 75, 249],
            [253, 76, 250],
            [254, 76, 251],
            [255, 76, 252],
            [256, 76, 253],
            [257, 50, 254],
            [258, 50, 255],
            [259, 50, 256],
            [260, 50, 257],
            [261, 50, 258],
            [262, 77, 262],
            [263, 77, 261],
            [264, 77, 263],
            [265, 77, 259],
            [266, 77, 260],
            [267, 77, 264],
            [268, 78, 265],
            [269, 78, 266],
            [270, 78, 267],
            [271, 78, 268],
            [272, 78, 269],
            [273, 78, 270],
            [274, 78, 271],
            [275, 78, 272],
            [276, 78, 274],
            [277, 78, 275],
            [278, 78, 273],
            [279, 78, 276],
            [298, 79, 268],
            [281, 79, 278],
            [297, 79, 266],
            [283, 79, 280],
            [284, 79, 281],
            [285, 79, 282],
            [286, 79, 283],
            [287, 79, 284],
            [288, 79, 285],
            [289, 79, 286],
            [290, 79, 287],
            [291, 79, 288],
            [292, 79, 289],
            [293, 79, 290],
            [294, 79, 291],
            [295, 79, 292],
            [296, 79, 293],
            [299, 80, 295],
            [300, 81, 296],
            [301, 82, 297],
            [302, 82, 298],
            [303, 82, 299],
            [304, 82, 300],
            [305, 83, 301],
            [306, 84, 291],
            [307, 84, 302],
            [308, 84, 303],
            [309, 85, 304],
            [310, 85, 305],
            [311, 85, 306],
            [312, 85, 307],
            [313, 85, 308],
            [314, 85, 310],
            [315, 85, 311],
            [316, 85, 309],
            [319, 86, 312],
            [318, 24, 105],
            [320, 87, 313],
            [321, 88, 314]
        ];
        foreach ($records as $record){
            DB::insert('insert into compagnonage_tache (id, compagnonage_id, tache_id) values (?, ?, ?)', $record);
        }
    }
}
