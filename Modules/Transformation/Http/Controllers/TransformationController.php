<?php

namespace Modules\Transformation\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

use App\Models\User;

use Modules\Transformation\Services\GererTransformationService;
use Modules\Transformation\Services\LivretPdfService;
use Modules\Transformation\Services\FichebilanPdfService;
use Modules\Transformation\Entities\Fonction;

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
        if (auth()->user()->can('transformation::transformation.updatelivret')) {
            $mode = "modiflivret";
        }
        if (auth()->user()->can('transformation::transformation.validerlacheoudouble')) {
            $mode = "validelacherdouble";
        }
        if (auth()->user()->can('transformation::transformation.updatelivret') && auth()->user()->can('transformation::transformation.validerlacheoudouble')) {
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

    public function monlivretpdf()
    {
        $user = auth()->user();
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
        return view('transformation::transformation.fichebilan', [
            'user' => $user,
            'mode' => $mode
        ]);
    }

    public function mafichebilan()
    {
        $user = auth()->user();
        return $this->fichebilan($user, $mode = 'proposition');
    }

    public function fichebilanpdf(User $user)
    {
        FichebilanPdfService::fichebilanpdf($user);
    }

    public function mafichebilanpdf()
    {
        $user = auth()->user();
        FichebilanPdfService::fichebilanpdf($user, $mode = 'proposition');
    }

    public function recalcultransfo(Request $request)
    {
        return view('transformation::transformation.recalcultransfo');
    }

    public function parcoursfichebilan()
    {
        return view('transformation::transformation.parcoursfichebilan');
    }

    public function choisirfonction(User $user)
    {
        $fonctions=Fonction::orderBy('fonction_liblong')->get();
        return view('transformation::transformation.choisirfonction', ['user' => $user,
                                              'fonctions' => $fonctions]);
    }
    
    public function attribuerfonction(Request $request, User $user)
    {
        $fonction_id = $request->fonction_id;
        $fonction = Fonction::find($fonction_id);
        if ($fonction == null){
            $fonctions=Fonction::orderBy('fonction_libcourt')->get()->diff($user->fonctions()->get());
            return redirect()->route('transformation::users.choisirfonction', ['user' => $user,
                                                           'fonctions' => $fonctions])->withError("Merci de selectionner une fonction");
        }
        
        $transformationService = new GererTransformationService;
        $transformationService->attachFonction($user, $fonction);

        $fonctions=Fonction::orderBy('fonction_libcourt')->get()->diff($user->fonctions()->get());
        
        return redirect()->route('transformation::users.choisirfonction', ['user' => $user,
                                                           'fonctions' => $fonctions]);
    }
    
    public function retirerfonction(Request $request, User $user)
    {
        $fonction_id = $request->fonction_id;
        $fonction = Fonction::find($fonction_id);
        
        $transformationService = new GererTransformationService;
        $transformationService->detachFonction($user, $fonction);
        
        $fonctions=Fonction::orderBy('fonction_libcourt')->get()->diff($user->fonctions()->get());

        return redirect()->route('transformation::users.choisirfonction', ['user' => $user,
                                                           'fonctions' => $fonctions]);
    }
}
