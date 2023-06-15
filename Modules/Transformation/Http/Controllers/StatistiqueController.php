<?php

namespace Modules\Transformation\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;

use Illuminate\Http\Request;

use Modules\Transformation\Services\StatService;

use Modules\Transformation\Entities\Statistique;
use Modules\Transformation\Entities\Stage;
use App\Models\User;
use App\Models\Service;
use Modules\Transformation\Entities\Fonction;

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

        return view('transformation::statistiques.index', ['period' => $period,
                                           'liste_des_periodes' => $liste_des_periodes,
                                           'statistiques'       => $statistiques]);
    }
    
    public function pourtuteurs()
    {
        $currentuser = auth()->user();
        $view = view('transformation::statistiques.pourtuteurs', ['currentuser' => $currentuser,]); 
        return $view;
    }
    
    public function parservice(Service $service)
    {
        $currentuser = auth()->user();
        $view = view('transformation::statistiques.pourtuteurs', ['currentuser' => $currentuser, 'service'=> $service]); 
        return $view;
    }
    
    public function pourem()
    {
        
        $stages = Stage::all();
        $users = User::with('secteur')->get();
        $services = Service::orderBy('service_libcourt')->get();
        $fonctionsaquai = Fonction::where('typefonction_id', 2);
        return view('transformation::statistiques.pourem', ['stages'   => $stages,
                                   'services' => $services,
                                   'fonctionsaquai' => $fonctionsaquai,
                                   'users'    => $users]);
    }

    public function dashboard()
    {
        return view('transformation::statistiques.dashboard');
    }
    
    public function dashboardarchive()
    {
        return view('transformation::statistiques.dashboardarchive');
    }
    
    public function parcomp()
    {
        return view('transformation::statistiques.parcomp');
    }
 
    public function pour2ps()
    {
        $stages = Stage::all();
        $stageext = [];
        $stagelic = [];
        foreach($stages as $stage){
            $idstage = $stage->id;
            $libstage = $stage->stage_libcourt;
            $nbmarinsavalider = $stage->users()
                                    ->wherePivotNull('date_validation')
                                    ->orWhere(function($query) use ($idstage){
                                        $query  ->where ('transformation_user_stage.stage_id', $idstage)
                                                ->whereNotNull('transformation_user_stage.date_validite')
                                                ->where('transformation_user_stage.date_validite', '<' , now());})
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
        return view('transformation::statistiques.pour2ps', ['stageexts' => $stageext,
                                            'stagelics' => $stagelic,
                                            'stages'=> $stages,
                                            ]);
    }
}