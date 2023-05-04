<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;

use Illuminate\Http\Request;

use App\Service\StatService;

use App\Models\Statistique;
use App\Models\Stage;
use App\Models\User;
use App\Models\Service;
use App\Models\Fonction;

class StatistiqueController extends Controller
{
    public function index(Request $request) 
    {
        if ($request->has("period"))
        {
            $period = $request["period"];
            $pieces = explode("-", $period);
            $date_calcul = Carbon::create($pieces[0], $pieces[1], 1,0,0,0);
        }
        else
        {
            $date_calcul = Carbon::now();
            $period =$date_calcul->format("Y") . "-" . $date_calcul->format("m");
        }
        
        if ($request->has("calcul")&& $request["period"]==$request["calcul"]) 
        {
            StatService::GenerateStatistics($date_calcul);
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
        $users = User::with('secteur')->get();
        $services = Service::orderBy('service_libcourt')->get();
        $fonctionsaquai = Fonction::where('typefonction_id', 2);

        return view('statistiques.pourem', ['stages'   => $stages,
                                   'services' => $services,
                                   'fonctionsaquai' => $fonctionsaquai,
                                   'users'    => $users]);
    }

    public function dashboard()
    {
        return view('statistiques.dashboard');
    }
    
    public function dashboardarchive()
    {
        return view('statistiques.dashboardarchive');
    }
    
    public function parcomp()
    {
        return view('statistiques.parcomp');
    }

 
    public function pour2ps()
    {
        
        $stages = Stage::all();
        $users = User::all();
        $services = Service::orderBy('service_libcourt')->get();
        $fonctionsaquai = Fonction::where('typefonction_id', 2);
        
        return view('statistiques.pour2ps', ['stages'   => $stages,
                                   'services' => $services,
                                   'fonctionsaquai' => $fonctionsaquai,
                                   'users'    => $users]);
    }
}