<?php

namespace App\Http\Controllers;

use App\Service\GererTransformationService;
use App\Jobs\CalculateUserTransformationRatios;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

use App\Models\Secteur;
use App\Models\Specialite;
use App\Models\Diplome;
use App\Models\Grade;
use App\Models\Unite;

use App\Models\Fonction;
use App\Models\TypeFonction;

class UsersController extends Controller
{
    /**
     * Display all users
     * 
     * @return \Illuminate\Http\Response
     */
    public function index() 
    {
        return view('users.index');
    }

    /**
     * Show form for creating user
     * 
     * @return \Illuminate\Http\Response
     */
    public function create() 
    {
        return view('users.create', [
            'roles' => Role::latest()->get(),
            'grades' => Grade::orderBy('ordre_classmt', 'desc')->get(),
            'specialites' => Specialite::orderBy('specialite_libcourt', 'asc')->get(),
            'diplomes' => Diplome::latest()->get(),
            'secteurs' => Secteur::orderBy('secteur_libcourt', 'asc')->get(),
            'unites' => Unite::orderBy('unite_libcourt', 'asc')->get()
        ]);
    }

    public static function generateRandomString($length = 10) {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
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
        $user = $user->create(array_merge($request->validated(), [ "password" =>$this->generateRandomString()]));
        // partie photo //
        if ($request->file('photo')){
            $filename = $user->id.'.'.$request->file('photo')->extension(); 
            $path = $request->file('photo')->storeAs(
                                                'photos', //repertoire
                                                $filename , //nom fichier
                                                'public' // espace de stockage
                                            );
            $user->photo=$path;
        }
        if ($request->has('socle'))
            $user->socle = true;
        else
            $user->socle = false;
        if ($request->has('comete'))
            $user->comete = true;
        else
            $user->comete = false;
       
        $user->name = strtoupper($user->name);
        $user->prenom = ucfirst(strtolower($user->prenom));
        $user->display_name = $user->displayString();
        $user->save();
        $user->syncRoles($request->get('role'));
        
        if (is_null($request->get('role')) or ! in_array("user", $request->get('role')))
        {
            $roletransfo = Role::where("name", "user")->get()->first();
            $user->roles()->attach($roletransfo);
        }

        if ($request["buttonid"] == "users.index")
            return redirect()->route("users.index")
                ->withSuccess(__('L utilisateur a été créé avec succès.'));
        elseif ($request["buttonid"] == "users.choisirfonction")
            return redirect()->route("users.choisirfonction", $user->id)
                ->withSuccess(__('L utilisateur a été créé avec succès.'));
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
        return view('users.show', [
            'user' => $user
        ]);
    }
    
    public function stages(User $user) 
    {
        return view('users.stages', [
            'marin' => $user
        ]);
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
        return view('users.edit', [
            'user' => $user,
            'userRole' => $user->roles->pluck('name')->toArray(),
            'roles' => Role::latest()->get(),
            'grades' => Grade::orderBy('ordre_classmt', 'desc')->get(),
            'specialites' => Specialite::orderBy('specialite_libcourt', 'asc')->get(),
            'diplomes' => Diplome::latest()->get(),
            'secteurs' => Secteur::orderBy('secteur_libcourt', 'asc')->get(),
            'unites' => Unite::orderBy('unite_libcourt', 'asc')->get()
        ]);
    }
    
    public function choisirfonction(User $user)
    {
        $fonctions=Fonction::orderBy('fonction_liblong')->get();
        return view('users.choisirfonction', ['user' => $user,
                                              'fonctions' => $fonctions]);
    }
    
    public function attribuerfonction(Request $request, User $user)
    {
        $fonction_id = $request->fonction_id;
        $fonction = Fonction::where('id', $fonction_id)->get()->first();
        if ($fonction == null){
            $fonctions=Fonction::orderBy('fonction_libcourt')->get()->diff($user->fonctions()->get());
            return redirect()->route('users.choisirfonction', ['user' => $user,
                                                           'fonctions' => $fonctions])->withError("Merci de selectionner une fonction");
        }
        
        $fmerid = TypeFonction::where('typfonction_libcourt', 'LIKE', 'mer')->get()->first()->id;
        $fquaiid = TypeFonction::where('typfonction_libcourt', 'LIKE', 'quai')->get()->first()->id;
        $fmetierid = TypeFonction::where('typfonction_libcourt', 'LIKE', 'metier')->get()->first()->id;
        
        $transformationService = new GererTransformationService;
        if ($fonction->typefonction_id == $fmerid)
        {
            $fonctionsmer = $user->fonctions()->where('typefonction_id', $fmerid)->get();
            if ($fonctionsmer->count() > 0)
            {
                foreach ($fonctionsmer as $fmer)
                {
                    $user->detachFonction($fmer);
                }
            }
            
            $transformationService->attachFonction($user, $fonction);
        }
        elseif ($fonction->typefonction_id == $fquaiid)
        {
            $fonctionsquai = $user->fonctions()->where('typefonction_id', $fquaiid)->get();
            if ($fonctionsquai->count() > 0)
            {
                foreach ($fonctionsquai as $fquai)
                {
                    $transformationService->detachFonction($user, $fonction);
                }
            }
            $transformationService->attachFonction($user, $fonction);
        }
        elseif ($fonction->typefonction_id == $fmetierid)
        {
            $transformationService->attachFonction($user, $fonction);
        }
        
        $fonctions=Fonction::orderBy('fonction_libcourt')->get()->diff($user->fonctions()->get());
        // recalcul tx transfo
        CalculateUserTransformationRatios::dispatch($user);
        return redirect()->route('users.choisirfonction', ['user' => $user,
                                                           'fonctions' => $fonctions]);
    }
    
    public function retirerfonction(Request $request, User $user)
    {
        $fonction_id = $request->fonction_id;
        $fonction = Fonction::where('id', $fonction_id)->get()->first();
        
        $transformationService = new GererTransformationService;
        $transformationService->detachFonction($user, $fonction);
        
        $fonctions=Fonction::orderBy('fonction_libcourt')->get()->diff($user->fonctions()->get());
        // recalcul tx transfo
        CalculateUserTransformationRatios::dispatch($user);
        return redirect()->route('users.choisirfonction', ['user' => $user,
                                                           'fonctions' => $fonctions]);
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
        // partie photo //
        if ($request->file('photo')){
            $filename = $user->id.'.'.$request->file('photo')->extension(); 
            $path = $request->file('photo')->storeAs(
                                                'photos', //repertoire
                                                $filename , //nom fichier
                                                'public' // espace de stockage
                                            );
            $user->photo=$path;
        }
        
        if ($request->has('socle'))
            $user->socle = true;
        else
            $user->socle = false;
        if ($request->has('comete'))
            $user->comete = true;
        else
            $user->comete = false;
        $user->update($request->validated());
        $user->name = strtoupper($user->name);
        $user->prenom = ucfirst(strtolower($user->prenom));
        $user->display_name = $user->displayString();
        $user->save();

        $user->syncRoles($request->get('role'));
        
        $user->save();

        return redirect()->route('users.index')
            ->withSuccess(__('Utilisateur mis a jour avec succes.'));
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
        $user->delete();

        return redirect()->route('users.index')
            ->withSuccess(__('Utilisateur supprimé avec succès.'));
    }
}
