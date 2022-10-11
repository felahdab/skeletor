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
        
        $liste_des_periodes = Statistique::all()->pluck('periode')->sortBy('periode')->unique();
        
        return view('statistiques.index', ['period' => $period,
                                           'liste_des_periodes' => $liste_des_periodes,
                                           'statistiques'       => $statistiques]);
    }
    
    public function pourtuteurs()
    {
        // Debugbar::startMeasure("controller", "Controller");
        $currentuser = auth()->user();
        $secteur_id = $currentuser->secteur_id;
        $service_id=$currentuser->service->id;

        $stages = Stage::all();
        $users = User::with('secteur')
                  ->orderBy('name','asc')
                  ->get()
                  ->where('secteur.service_id', $service_id)
                  ->where('en_transformation', true);
        // $users = User::with('secteur.service')->orderBy('name','asc')
            // ->join ('secteurs', 'users.secteur_id','=','secteurs.id')
            // ->where ('secteurs.service_id', $service_id)
            // ->get()
            
 // ddd($users);           
// $users = User::orderBy('name','asc')->where('secteur_id', $secteur_id)->get()->where('en_transformation', true);
        $services = Service::orderBy('service_libcourt')->get();
        $fonctionsaquai = Fonction::where('typefonction_id', 2);
        
        // Debugbar::startMeasure("render", "Rendering");
        $view = view('statistiques.pourtuteurs', ['currentuser' => $currentuser,
                                    'stages'   => $stages,
                                   'services' => $services,
                                   'fonctionsaquai' => $fonctionsaquai,
                                   'users'    => $users]); 
        // Debugbar::stopMeasure("render");
        // Debugbar::stopMeasure("controller");
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