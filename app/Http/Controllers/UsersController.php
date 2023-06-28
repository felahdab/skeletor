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

use Modules\Transformation\Entities\Fonction;

use OpenApi\Annotations as OA;

use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;

class UsersController extends Controller
{
    
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
            'grades' => Grade::orderBy('ordre_classmt', 'asc')->get(),
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

        Mail::to($user->email)
        ->queue(new WelcomeMail($user));


        if ($request["buttonid"] == "users.index")
            return redirect()->route("users.index")
                ->withSuccess(__('L utilisateur a été créé avec succès.'));
        elseif ($request["buttonid"] == "users.choisirfonction")
            return redirect()->route("transformation::users.choisirfonction", $user->id)
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
            'grades' => Grade::orderBy('ordre_classmt', 'asc')->get(),
            'specialites' => Specialite::orderBy('specialite_libcourt', 'asc')->get(),
            'diplomes' => Diplome::latest()->get(),
            'secteurs' => Secteur::orderBy('secteur_libcourt', 'asc')->get(),
            'unites' => Unite::orderBy('unite_libcourt', 'asc')->get()
        ]);
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
        if ($user->date_debarq == null)
        {
            return redirect()->route('users.index')
            ->withError(__('Vous devez renseigner la date de débarquement avant de supprimer un utilisateur.'));
        }
        $user->delete();

        return redirect()->route('users.index')
            ->withSuccess(__('Utilisateur supprimé avec succès.'));
    }
}
