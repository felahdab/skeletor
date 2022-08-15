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
    
    public function updatelivret(Request $request, User $user)
    {
        if ($request->has("validation"))
        {
            if ($request->has('ssobjid'))
            {
                $sous_objectifs_a_valider = $request['ssobjid'];
                foreach ($sous_objectifs_a_valider as $key => $value){
                    $sousobjectif = SousObjectif::find($key);
                    $user->sous_objectifs()->attach($sousobjectif);
                    $workitem = $user->sous_objectifs()->find($sousobjectif)->pivot;
                    $workitem->valideur=auth()->user()->displayString();
                    $workitem->commentaire="test";
                    $workitem->save();
                    $workitem->date_validation = $workitem->updated_at;
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
                            $workitem->valideur=auth()->user()->displayString();
                            $workitem->commentaire="test";
                            $workitem->save();
                            $workitem->date_validation = $workitem->updated_at;
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
        $userfonc = $user->fonctions->find($fonction);
        if ($request->has('validation_lache'))
        {
            // L'utilisateur a cliqué sur un bouton de validation du lache
            $userfonc->pivot->commentaire_lache="test";
            $userfonc->pivot->valideur_lache=auth()->user()->displayString();
            $userfonc->pivot->save();
            
            $userfonc->pivot->date_lache = $user->fonctions->find($fonction)->pivot->updated_at;
            $userfonc->pivot->save();
        }
        elseif ($request->has('validation_double'))
        {
            // L'utilisateur a cliqué sur un bouton de validation du double
            $userfonc->pivot->commentaire_double="test";
            $userfonc->pivot->valideur_double=auth()->user()->displayString();
            $userfonc->pivot->save();
            
            $userfonc->pivot->date_double = $userfonc->pivot->updated_at;
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
