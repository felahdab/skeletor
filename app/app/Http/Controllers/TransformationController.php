<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Secteur;
use App\Models\Specialite;
use App\Models\Diplome;
use App\Models\Grade;
use App\Models\Unite;

use App\Models\Fonction;
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
        // var_dump($request->input());
        var_dump($request);
    }

    public function validerlacheoudouble(Request $request, User $user, Fonction $fonction)
    {
        if ($request->has('validation_lache'))
        {
            $user->fonctions->find($fonction)->pivot->commentaire_lache="test";
            $user->fonctions->find($fonction)->pivot->valideur_lache=auth()->user()->displayString();
            
            $user->fonctions->find($fonction)->pivot->save();
            $user->fonctions->find($fonction)->pivot->date_lache = $user->fonctions->find($fonction)->pivot->updated_at;
            $user->fonctions->find($fonction)->pivot->save();
        }
        elseif ($request->has('validation_double'))
        {
            $user->fonctions->find($fonction)->pivot->commentaire_double="test";
            $user->fonctions->find($fonction)->pivot->valideur_double=auth()->user()->displayString();
            
            $user->fonctions->find($fonction)->pivot->save();
            $user->fonctions->find($fonction)->pivot->date_double = $user->fonctions->find($fonction)->pivot->updated_at;
            $user->fonctions->find($fonction)->pivot->save();
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
