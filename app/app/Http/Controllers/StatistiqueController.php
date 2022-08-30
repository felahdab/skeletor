<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;

use Illuminate\Http\Request;

use App\Models\Statistique;

class StatistiqueController extends Controller
{
    public function index(Request $request) 
    {
        $date_stat = Carbon::now();
        $defaultperiod = $date_stat->year . "/" . $date_stat->month;
        
        if ($request->has("period"))
            $period = $request["period"];
        else
        {
            $period = $defaultperiod;
        }
        
        $statistiques = Statistique::all()->where("periode", $period);
        
        $liste_des_periodes = Statistique::all()->pluck('periode')->sortBy('periode')->unique();
        
        return view('statistiques.index', ['period' => $period,
                                           'liste_des_periodes' => $liste_des_periodes,
                                           'statistiques'       => $statistiques]);
    }
}
