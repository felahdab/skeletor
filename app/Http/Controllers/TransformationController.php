<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Artisan;

use App\Console\Commands\RecalculerTransformation;
use App\Console\Commands;

use App\Service\LivretPdfService;

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
        return view('transformation.index');
    }
    
    public function indexparfonction(Request $request) 
    {
        return view('transformation.indexparfonction');
    }
    
    public function indexparstage(Request $request) 
    {
        return view('transformation.indexparstage');
    }

    public function indexparcomp()
    {
        return view('transformation.indexparcomp');
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
        LivretPdfService::livretpdf($user, 'imprim');
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
    
    public function recalcultransfo(Request $request) 
    {
        if ($request->has("mode"))
        {
            Artisan::call('ffast:recalculertransformation');
            return view('transformation.recalcultransfo')
                ->withSuccess(__('Calcul terminé'));
        }
        return view('transformation.recalcultransfo');
    }

    public function parcoursfichebilan()
    {
        return view('transformation.parcoursfichebilan');
    }
}
