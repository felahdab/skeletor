<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;

use Illuminate\Http\Request;

use App\Models\Statistique;

use App\Models\Stage;
use App\Models\User;
use App\Models\Service;
use App\Models\Fonction;

use Barryvdh\Debugbar\Facades\Debugbar;

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
        
        $liste_des_periodes = Statistique::all()->pluck('periode')->sort()->unique();

        return view('statistiques.index', ['period' => $period,
                                           'liste_des_periodes' => $liste_des_periodes,
                                           'statistiques'       => $statistiques]);
    }
    
    public function pourtuteurs()
    {
        $currentuser = auth()->user();
        $view = view('statistiques.pourtuteurs', ['currentuser' => $currentuser,]); 
        return $view;
    }
    
    public function parservice(Service $service)
    {
        $currentuser = auth()->user();
        $view = view('statistiques.pourtuteurs', ['currentuser' => $currentuser, 'service'=> $service]); 
        return $view;
    }
    
    public function pourem()
    {
        
        $stages = Stage::all();
        $users = User::local()->with('secteur')->get();
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