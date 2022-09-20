<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

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
        $users = User::local()->orderBy('name')->paginate(10);

        return view('users.index', compact('users'));
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

    function generateRandomString($length = 10) {
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
        
        $roletransfo = Role::where("name", "user")->get()->first();
        $user->roles()->attach($roletransfo);
        

        return redirect()->route('users.index')
            ->withSuccess(__('Utilisateur a été créé avec succès. Vous devez changer son mot de passe.'));
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
        $fonctions=Fonction::orderBy('fonction_libcourt')->get();
        return view('users.choisirfonction', ['user' => $user,
                                              'fonctions' => $fonctions]);
    }
    
    public function attribuerfonction(Request $request, User $user)
    {
        $fonction_id = $request->fonction_id;
        $fonction = Fonction::where('id', $fonction_id)->get()->first();
        
        $fmerid = TypeFonction::where('typfonction_libcourt', 'LIKE', 'mer')->get()->first()->id;
        $fquaiid = TypeFonction::where('typfonction_libcourt', 'LIKE', 'quai')->get()->first()->id;
        $fmetierid = TypeFonction::where('typfonction_libcourt', 'LIKE', 'metier')->get()->first()->id;
        
        if ($fonction->typefonction_id == $fmerid)
        {
            $fonctionsmer = $user->fonctions()->where('typefonction_id', $fmerid)->get();
            if ($fonctionsmer->count() > 0)
            {
                foreach ($fonctionsmer as $fmer)
                {
                    $user->fonctions()->detach($fmer);
                }
            }
            $user->fonctions()->attach($fonction);
        }
        elseif ($fonction->typefonction_id == $fquaiid)
        {
            $fonctionsquai = $user->fonctions()->where('typefonction_id', $fquaiid)->get();
            if ($fonctionsquai->count() > 0)
            {
                foreach ($fonctionsquai as $fquai)
                {
                    $user->fonctions()->detach($fquai);
                }
            }
            $user->fonctions()->attach($fonction);
        }
        elseif ($fonction->typefonction_id == $fmetierid)
        {
            $user->fonctions()->attach($fonction);
        }
        
        $fonctions=Fonction::orderBy('fonction_libcourt')->get()->diff($user->fonctions()->get());
        return redirect()->route('users.choisirfonction', ['user' => $user,
                                                           'fonctions' => $fonctions]);
    }
	
	public function retirerfonction(Request $request, User $user)
    {
        $fonction_id = $request->fonction_id;
        $fonction = Fonction::where('id', $fonction_id)->get()->first();
        
        $user->fonctions()->detach($fonction);
        
        $fonctions=Fonction::orderBy('fonction_libcourt')->get()->diff($user->fonctions()->get());
        return redirect()->route('users.choisirfonction', ['user' => $user,
                                                           'fonctions' => $fonctions]);
    }

    public function attribuerstage(Request $request, User $user)
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
        $user->update($request->validated());

        $user->syncRoles($request->get('role'));
        
        // $grade = Grade::where('id',intval($request->get('grade')))->first();
        // $user->grade()->associate($grade);

        // $specialite = Specialite::where('id',intval($request->get('specialite')))->first();
        // $user->specialite()->associate($specialite);

        // $diplome = Diplome::where('id',intval($request->get('diplome')))->first();
        // $user->diplome()->associate($diplome);

        // $unite_destination = Unite::where('id',intval($request->get('unite_destination')))->first();
        // $user->unite_destination()->associate($unite_destination);

        // $secteur = Secteur::where('id',intval($request->get('secteur')))->first();
        // $user->secteur()->associate($secteur);
        
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