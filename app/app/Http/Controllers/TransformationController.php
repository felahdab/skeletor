<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Secteur;
use App\Models\Specialite;
use App\Models\Diplome;
use App\Models\Grade;
use App\Models\Unite;

use App\Models\Tache;
use App\Models\Fonction;
use App\Models\SousObjectif;
use App\Models\TypeFonction;
use App\Models\Stage;

use Illuminate\Support\Facades\Storage;

use App\Jobs\CalculateUserTransformationRatios;

class TransformationController extends Controller
{
    /**
     * Display all users
     * 
     * @return \Illuminate\Http\Response
     */
    public function index() 
    {
        $users = User::local()->paginate(10);
        return view('transformation.index', ['users' => $users]);
    }
    
    public function indexparfonction(Request $request) 
    {
       if ($request->has('filter') )
        {
            $filter = $request->input('filter');
            $fonctions = Fonction::where('fonction_libcourt', 'LIKE', '%'.$filter.'%')->orderBy('fonction_libcourt')->paginate(10);
        } else {
            $filter="";
            $fonctions = Fonction::orderBy('fonction_libcourt')->paginate(10);
        }
        return view('transformation.indexparfonction', ['fonctions' => $fonctions,
                                                           'filter' => $filter]);
    }
    
    public function indexparstage(Request $request) 
    {
        
        $stages = Stage::orderBy('stage_libcourt')->paginate(10);
        return view('transformation.indexparstage', ['stages' => $stages]);
    }

    /**
     * Show form for creating user
     * 
     * @return \Illuminate\Http\Response
     */
    public function livret(User $user) 
    {
        $readwrite=true;
        return view('transformation.livret', ['user'     => $user,
                                              'readwrite' => $readwrite]);
    }
    
    public function monlivret() 
    {
        $user = auth()->user();
        $readwrite=false;
        return view('transformation.livret', ['user' => $user,
                                              'readwrite' => $readwrite]);
    }
    
    public function livretpdf(User $user)
    {
        $pathbrest = Storage::path('public/livret-gtr-brest.jpg');
        $pathtln = Storage::path('public/livret-gtr-toulon.jpg');

        $html = view('transformation.livretpdf', ['user' => $user,
            'pathbrest' => $pathbrest,
            'pathtln'   => $pathtln])->render();

        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 
                            'format' => 'A4',
                            'margin_left' => 10,
                            'margin_right' => 10,
                            'margin_top' => 15,
                            'margin_bottom' => 15
                            ]);
        $mpdf->SetTitle('Livret de transformation');
        $mpdf->setFooter('{PAGENO}/{nb}');
        $mpdf->WriteHTML($html);
        $nomfic=date('Ymd')."_Livret de transformation de ".$user->name."_".$user->prenom.".pdf";
        $mpdf->Output($nomfic,'D');
    }
    
    public function progression(User $user)
    {
        $readwrite=true;
        return view('transformation.progression', ['user' => $user,
                                                    'readwrite' => $readwrite]);
    }
    
    public function maprogression()
    {
        $user = auth()->user();
        $readwrite=false;
        return view('transformation.progression', ['user' => $user,
                                                   'readwrite' => $readwrite]);
    }
    
    public function fichebilan(User $user, $readwrite=true)
    {
        $listcomp = [];
        $liststage= [];
        foreach($user->fonctions()->get() as $fonction)
        {
            foreach($fonction->compagnonages()->get() as $comp)
                array_push($listcomp, $comp);
        }
        foreach($user->stages()->get() as $stage)
            array_push($liststage, $stage);
        
        $nbcomp=count($listcomp);
        $nbstage=count($liststage);
        
        if ($nbcomp == $nbstage)
            ;
        elseif ($nbcomp > $nbstage)
        {
            $complement = array_fill(0, $nbcomp - $nbstage, null);
            $liststage = array_merge($liststage, $complement);
        }
        elseif ($nbcomp < $nbstage)
        {
            $complement = array_fill(0, $nbstage - $nbcomp, null);
            $listcomp = array_merge($listcomp, $complement);
        }
        
        // $readwrite=true;
        return view('transformation.fichebilan', ['user' => $user,
                                                  'listcomp' => $listcomp,
                                                  'liststage' => $liststage,
                                                  'readwrite' => $readwrite]);
    }
    
    public function mafichebilan()
    {
        $user = auth()->user();
        return $this->fichebilan($user, $readwrite=false);
    }
    
    public function updatelivret(Request $request, User $user)
    {
        $valideur = $request->input('valideur');
        $commentaire = $request->input('commentaire');
        $date_validation = $request->input('date_validation');
        
        if ($date_validation == null)
            $date_validation = date('Y-m-d');
        if ($request->input("buttonid") == "validation")
        {
            if ($request->has('ssobjid'))
            {
                $sous_objectifs_a_valider = $request['ssobjid'];
                foreach ($sous_objectifs_a_valider as $key => $value){
                    $sousobjectif = SousObjectif::find($key);
                    $user->sous_objectifs()->attach($sousobjectif, [
                        'valideur'=> $valideur,
                        'commentaire'=> $commentaire,
                        'date_validation' => $date_validation,
                    ]);
                    $event_detail = [
                        "sous_objectif" => $sousobjectif,
                        "commentaire" => $commentaire,
                        "date_validation" => $date_validation,
                    ];
                    $user->logTransformationHistory("VALIDE_SOUS_OBJECTIF", json_encode($event_detail));
                }
            }
            if ($request->has('tacheid'))
            {
                $taches_a_valider = $request['tacheid'];
                foreach ($taches_a_valider as $key => $value){
                    $tache = Tache::find($key);
                    $event_detail = [
                        "tache" => $tache,
                        "commentaire" => $commentaire,
                        "date_validation" => $date_validation,
                    ];
                    $user->logTransformationHistory("VALIDE_TACHE", json_encode($event_detail));
                    foreach ($tache->objectifs()->get() as $objectif)
                    {
                        foreach($objectif->sous_objectifs()->get() as $sous_objectif)
                        {
                            $user->sous_objectifs()->attach($sous_objectif, [
                                'valideur' => $valideur,
                                'commentaire' => $commentaire,
                                'date_validation' => $date_validation,
                            ]);
                            $event_detail = [
                                "sous_objectif" => $sous_objectif,
                                "commentaire" => $commentaire,
                                "date_validation" => $date_validation,
                            ];
                            $user->logTransformationHistory("VALIDE_SOUS_OBJECTIF", json_encode($event_detail));
                        }
                    }
                }
            }
        }
        elseif ($request->has("annulation_validation"))
        {
            if ($request->has('ssobjid'))
            {
                $sous_objectifs_a_valider = $request['ssobjid'];
                foreach ($sous_objectifs_a_valider as $key => $value){
                    $sous_objectif = SousObjectif::find($key);
                    $user->sous_objectifs()->detach($sous_objectif);
                    $user->logTransformationHistory("DEVALIDE_SOUS_OBJECTIF", json_encode(["sous_objectif" => $sous_objectif]));
                }
            }
            if ($request->has('tacheid'))
            {
                $taches_a_valider = $request['tacheid'];
                foreach ($taches_a_valider as $key => $value){
                    $tache = Tache::find($key);
                    $user->logTransformationHistory("DEVALIDE_TACHE", json_encode(["tache" => $tache]));
                    foreach ($tache->objectifs()->get() as $objectif)
                    {
                        foreach($objectif->sous_objectifs()->get() as $sous_objectif)
                        {
                            $user->sous_objectifs()->detach($sous_objectif);
                            $user->logTransformationHistory("DEVALIDE_SOUS_OBJECTIF", json_encode(["sous_objectif" => $sous_objectif]));
                        }
                    }
                }
            }
            if ($request->has('stageid'))
            {
                $stages_a_valider = $request['stageid'];
                foreach ($stages_a_valider as $key => $value){
                    $stage = Stage::find($key);
                    $workitem= $user->stages()->find($stage)->pivot;
                    $workitem->date_validation=null;
                    $workitem->commentaire=null;
                    $workitem->save();
                    $user->logTransformationHistory("DEVALIDE_STAGE", json_encode(["stage" => $stage]));
                }
            }
        }
        CalculateUserTransformationRatios::dispatch($user);
        return redirect()->route('transformation.livret', ['user' => $user]);
     }

    public function validerlacheoudouble(Request $request, User $user, Fonction $fonction)
    {
        $valideur = $request->input('valideur');
        $commentaire = $request->input('commentaire');
        $date_validation = $request->input('date_validation');
        
        $userfonc = $user->fonctions->find($fonction);
        if ($request->input("buttonid") == "validation_lache")
        {
            // L'utilisateur a cliqué sur un bouton de validation du lache
            // Si la fonction necessite un double, il faut que le double soit valide avant le lache
            if ($userfonc->pivot->date_double != null or !$fonction->fonction_double) 
            {
                $userfonc->pivot->commentaire_lache=$commentaire;
                $userfonc->pivot->valideur_lache=$valideur;
                $userfonc->pivot->date_lache = $date_validation;
                $userfonc->pivot->save();
                $event_detail = [
                    "fonction" => $fonction,
                    "commentaire" => $commentaire,
                    "date_validation" => $date_validation,
                ];
                $user->logTransformationHistory("VALIDE_LACHE_FONCTION", json_encode($event_detail));
            }
            else
            {
                return redirect()->route('transformation.livret', ['user' => $user])->withErrors('Si une fonction necessite un tour en double valide, ce dernier doit etre valide avant le lache');
            }
        }
        elseif ($request->input("buttonid") == "validation_double")
        {
            // L'utilisateur a cliqué sur un bouton de validation du double
            $userfonc->pivot->commentaire_double=$commentaire;
            $userfonc->pivot->valideur_double=$valideur;
            $userfonc->pivot->date_double = $date_validation;
            $userfonc->pivot->save();
            $event_detail = [
                "fonction" => $fonction,
                "commentaire" => $commentaire,
                "date_validation" => $date_validation,
            ];
            $user->logTransformationHistory("VALIDE_DOUBLE_FONCTION", json_encode($event_detail));
        }
        elseif ($request->has('annulation_double'))
        {
            $userfonc->pivot->commentaire_double=null;
            $userfonc->pivot->valideur_double=null;
            $userfonc->pivot->date_double = null;
            $userfonc->pivot->save();
            $user->logTransformationHistory("ANNULE_DOUBLE_FONCTION", json_encode(["fonction" => $fonction]));
        }
        elseif ($request->has('annulation_lache'))
        {
            $userfonc->pivot->commentaire_lache=null;
            $userfonc->pivot->valideur_lache=null;
            $userfonc->pivot->date_lache = null;
            $userfonc->pivot->save();
            $user->logTransformationHistory("ANNULE_LACHE_FONCTION", json_encode(["fonction" => $fonction]));
        }
        return redirect()->route('transformation.livret', ['user' => $user])->withSuccess('Mise a jour reussie.');
    }
}
