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
    
}
