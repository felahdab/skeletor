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


class TransformationController extends Controller
{
    /**
     * Display all users
     * 
     * @return \Illuminate\Http\Response
     */
    public function index() 
    {
        $users = User::paginate(10);
        return view('transformation.index', ['users' => $users]);
    }

    /**
     * Show form for creating user
     * 
     * @return \Illuminate\Http\Response
     */
    public function livret(User $user) 
    {
        return view('transformation.livret', ['user' => $user]);
    }
    
    public function progression(User $user)
    {
        return view('transformation.progression', ['user' => $user]);
    }
    
    public function updatelivret(Request $request, User $user)
    {
        $valideur = $request->input('valideur');
        $commentaire = $request->input('commentaire');
        $date_validation = $request->input('date_validation');
        
        if ($request->input("buttonid") == "validation")
        {
            if ($request->has('ssobjid'))
            {
                $sous_objectifs_a_valider = $request['ssobjid'];
                foreach ($sous_objectifs_a_valider as $key => $value){
                    $sousobjectif = SousObjectif::find($key);
                    $user->sous_objectifs()->attach($sousobjectif);
                    $workitem = $user->sous_objectifs()->find($sousobjectif)->pivot;
                    $workitem->valideur=$valideur;
                    $workitem->commentaire=$commentaire;
                    $workitem->date_validation = $date_validation;
                    $workitem->save();
                }
            }
            if ($request->has('tacheid'))
            {
                $taches_a_valider = $request['tacheid'];
                foreach ($taches_a_valider as $key => $value){
                    $tache = Tache::find($key);
                    foreach ($tache->objectifs()->get() as $objectif)
                    {
                        foreach($objectif->sous_objectifs()->get() as $sous_objectif)
                        {
                            $user->sous_objectifs()->attach($sous_objectif);
                            $workitem = $user->sous_objectifs()->find($sous_objectif)->pivot;
                            $workitem->valideur=$valideur;
                            $workitem->commentaire=$commentaire;
                            $workitem->date_validation = $date_validation;
                            $workitem->save();
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
                    $sousobjectif = SousObjectif::find($key);
                    $user->sous_objectifs()->detach($sousobjectif);
                }
            }
            if ($request->has('tacheid'))
            {
                $taches_a_valider = $request['tacheid'];
                foreach ($taches_a_valider as $key => $value){
                    $tache = Tache::find($key);
                    foreach ($tache->objectifs()->get() as $objectif)
                    {
                        foreach($objectif->sous_objectifs()->get() as $sous_objectif)
                        {
                            $user->sous_objectifs()->detach($sous_objectif);
                        }
                    }
                }
            }
        }
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
            $userfonc->pivot->commentaire_lache=$commentaire;
            $userfonc->pivot->valideur_lache=$valideur;
            $userfonc->pivot->date_lache = $date_validation;
            $userfonc->pivot->save();
        }
        elseif ($request->input("buttonid") == "validation_double")
        {
            // L'utilisateur a cliqué sur un bouton de validation du double
            $userfonc->pivot->commentaire_double=$commentaire;
            $userfonc->pivot->valideur_double=$valideur;
            $userfonc->pivot->date_double = $date_validation;
            $userfonc->pivot->save();
        }
        elseif ($request->has('annulation_double'))
        {
            $userfonc->pivot->commentaire_double=null;
            $userfonc->pivot->valideur_double=null;
            $userfonc->pivot->date_double = null;
            $userfonc->pivot->save();
        }
        elseif ($request->has('annulation_lache'))
        {
            $userfonc->pivot->commentaire_lache=null;
            $userfonc->pivot->valideur_lache=null;
            $userfonc->pivot->date_lache = null;
            $userfonc->pivot->save();
        }
        return redirect()->route('transformation.livret', ['user' => $user]);
    }

    /**
     * Store a newly created user
     * 
     * @param User $user
     * @param StoreUserRequest $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(User $user, StoreUserRequest $request) 
    {
        
    }

    /**
     * Show user data
     * 
     * @param User $user
     * 
     * @return \Illuminate\Http\Response
     */
    public function show(User $user) 
    {

    }

    /**
     * Edit user data
     * 
     * @param User $user
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user) 
    {

    }
    
    public function choisirfonction(User $user)
    {

    }
    
    public function attribuerfonction(Request $request, User $user)
    {

    }
    
    public function retirerfonction(Request $request, User $user)
    {

    }

    /**
     * Update user data
     * 
     * @param User $user
     * @param UpdateUserRequest $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(User $user, UpdateUserRequest $request) 
    {

    }

    /**
     * Delete user data
     * 
     * @param User $user
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user) 
    {
        
    }
}
