<?php

namespace Modules\Transformation\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Artisan;

use App\Console\Commands\RecalculerTransformation;
use App\Console\Commands;

use Modules\Transformation\Services\LivretPdfService;

use App\Models\User;
use App\Models\Secteur;
use App\Models\Specialite;
use App\Models\Diplome;
use App\Models\Grade;
use App\Models\Unite;

use Modules\Transformation\Entities\Tache;
use Modules\Transformation\Entities\Fonction;
use Modules\Transformation\Entities\SousObjectif;
use Modules\Transformation\Entities\TypeFonction;
use Modules\Transformation\Entities\Stage;

use Illuminate\Support\Facades\Storage;

class TransformationController extends Controller
{
    /**
     * Display all users
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('transformation::transformation.index');
    }

    public function indexparfonction(Request $request)
    {
        return view('transformation::transformation.indexparfonction');
    }

    public function indexparstage(Request $request)
    {
        return view('transformation::transformation.indexparstage');
    }

    public function indexparcomp()
    {
        return view('transformation::transformation.indexparcomp');
    }

    /**
     * Show form for creating user
     * 
     * @return \Illuminate\Http\Response
     */
    public function livret(User $user)
    {
        //conditions sur permission
        $mode = "consultation";
        if (auth()->user()->can('transformation.updatelivret')) {
            $mode = "modiflivret";
        }
        if (auth()->user()->can('transformation.validerlacheoudouble')) {
            $mode = "validelacherdouble";
        }
        if (auth()->user()->can('transformation.updatelivret') && auth()->user()->can('transformation.validerlacheoudouble')) {
            $mode = "modification";
        }

        return view('transformation::transformation.livret', [
            'mode'      => $mode,
            'user'      => $user
        ]);
    }

    public function monlivret()
    {
        $user = auth()->user();
        return view('transformation::transformation.livret', [
            'mode' => 'proposition',
            'user' => $user
        ]);
    }

    public function livretpdf(User $user)
    {
        LivretPdfService::livretpdf($user, 'imprim');
    }

    public function progression(User $user)
    {
        $readwrite = true;
        return view('transformation::transformation.progression', [
            'user' => $user,
            'mode' => 'consultation'
        ]);
    }

    public function maprogression()
    {
        $user = auth()->user();
        return view('transformation::transformation.progression', [
            'mode' => 'proposition',
            'user' => $user
        ]);
    }

    public function fichebilan(User $user, $mode = 'consultation')
    {
        $listcomp = [];
        $liststage = [];
        foreach ($user->fonctions()->get() as $fonction) {
            foreach ($fonction->compagnonages()->get() as $comp)
                array_push($listcomp, $comp);
        }
        foreach ($user->stages()->get() as $stage)
            array_push($liststage, $stage);

        // $nbcomp = count($listcomp);
        // $nbstage = count($liststage);

        // if ($nbcomp == $nbstage);
        // elseif ($nbcomp > $nbstage) {
        //     $complement = array_fill(0, $nbcomp - $nbstage, null);
        //     $liststage = array_merge($liststage, $complement);
        // } elseif ($nbcomp < $nbstage) {
        //     $complement = array_fill(0, $nbstage - $nbcomp, null);
        //     $listcomp = array_merge($listcomp, $complement);
        // }

        // $readwrite=true;
        return view('transformation::transformation.fichebilan', [
            'user' => $user,
            'listcomp' => $listcomp,
            'liststage' => $liststage,
            'mode' => $mode
        ]);
    }

    public function mafichebilan()
    {
        $user = auth()->user();
        return $this->fichebilan($user, $mode = 'proposition');
    }

    public function recalcultransfo(Request $request)
    {
        if ($request->has("mode")) {
            Artisan::call('ffast:recalculertransformation');
            return view('transformation::transformation.recalcultransfo')
                ->withSuccess(__('Calcul terminé'));
        }
        return view('transformation::transformation.recalcultransfo');
    }

    public function parcoursfichebilan()
    {
        return view('transformation::transformation.parcoursfichebilan');
    }
}
