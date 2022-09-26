<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;

use Illuminate\Http\Request;

use App\Models\Statistique;

use App\Models\Stage;
use App\Models\User;
use App\Models\Service;
use App\Models\Fonction;

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
    
    public function pourtuteurs()
    {
        
        $stages = Stage::all();
        $users = User::local();
        $services = Service::orderBy('service_libcourt')->get();
        $fonctionsaquai = Fonction::where('typefonction_id', 2);
        
        return view('statistiques.pourtuteurs', ['stages'   => $stages,
                                   'services' => $services,
                                   'fonctionsaquai' => $fonctionsaquai,
                                   'users'    => $users]);
    }
    
    public function pourem()
    {
        
        $stages = Stage::all();
        $users = User::local();
        $services = Service::orderBy('service_libcourt')->get();
        $fonctionsaquai = Fonction::where('typefonction_id', 2);
        
        return view('statistiques.pourem', ['stages'   => $stages,
                                   'services' => $services,
                                   'fonctionsaquai' => $fonctionsaquai,
                                   'users'    => $users]);
    }
    
    public function pour2ps()
    {
        
        $stages = Stage::all();
        $users = User::local();
        $services = Service::orderBy('service_libcourt')->get();
        $fonctionsaquai = Fonction::where('typefonction_id', 2);
        
        return view('statistiques.pour2ps', ['stages'   => $stages,
                                   'services' => $services,
                                   'fonctionsaquai' => $fonctionsaquai,
                                   'users'    => $users]);
    }
}