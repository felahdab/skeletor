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
    //crer la liste des stages sous licence [idstage, libstage, nbmarinsavalider]
    //     $stagelic = [];
    //     foreach($stages as $stage){
    //         // dd($stage);
    //         if($stage->typelicence_id < 4){
    //             $idstage = $stage->id;
    //             $libstage = $stage->stage_libcourt;
    //             $nbmarinsavalider = $stage->users()->wherePivotNull('date_validation')
    //                                                 ->orWhere(function($query){
    //                                                     $query->whereNotNull('user_stage.date_validite')
    //                                                             ->where('user_stage.date_validite', '<' , now());
    //                                                 })
    //                                                 ->get()->count();
    //         $ligne=[$idstage, $libstage, $nbmarinsavalider];
    //             if($nbmarinsavalider > 0){
    //                 array_push($stagelic, $ligne);
    //             }
    //         }
    //     }
    //   //dd($stagelic);
        


    //         //creer la liste des stages ext [idstage, libstage, nbmarinsavalider]
    //         $stageext = [];
    //         foreach($stages as $stage){
    //             // dd($stage);
    //             if($stage->typelicence_id == 4){
    //                 $idstage = $stage->id;
    //                 $libstage = $stage->stage_libcourt;
                
    //                 $nbmarinsavalider = $stage->users()
    //                                             ->wherePivotNull('date_validation')
    //                                             ->orWhere(function($query) use ($idstage){
    //                                                 $query  ->where ('user_stage.stage_id', $idstage)
    //                                                         ->whereNotNull('user_stage.date_validite')
    //                                                         ->where('user_stage.date_validite', '<' , now());
    //                                             })
    //                                             ->get()
    //                                             ->count();

    //                 $ligne=[$idstage, $libstage, $nbmarinsavalider];
    //                 array_push($stageext, $ligne);
    //             }
    //         }
            // dd($stageext);   
        $stageext = [];
        $stagelic = [];
        foreach($stages as $stage){
            $idstage = $stage->id;
            $libstage = $stage->stage_libcourt;
            $nbmarinsavalider = $stage->users()
            ->wherePivotNull('date_validation')
            ->orWhere(function($query) use ($idstage){
                $query  ->where ('user_stage.stage_id', $idstage)
                        ->whereNotNull('user_stage.date_validite')
                        ->where('user_stage.date_validite', '<' , now());})
            ->get()
            ->count();
            if($nbmarinsavalider > 0){
                $ligne=['idstage' => $idstage, 'libstage' => $libstage, 'nbmarinsavalider' =>$nbmarinsavalider];
                if($stage->typelicence_id < 4){
                    array_push($stagelic, $ligne);    
                }
                elseif($stage->typelicence_id = 4){
                    array_push($stageext, $ligne);
                }
            }
        }
         //   dd($stagelic);
        return view('statistiques.pour2ps', ['stageexts' => $stageext,
                                            'stagelics' => $stagelic,
                                            'stages'=> $stages,
                                            ]);
    }
}