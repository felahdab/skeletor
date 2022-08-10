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

class UsersController extends Controller
{
    /**
     * Display all users
     * 
     * @return \Illuminate\Http\Response
     */
    public function index() 
    {
        $users = User::latest()->paginate(10);

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
			'specialites' => Specialite::latest()->get(),
			'diplomes' => Diplome::latest()->get(),
			'secteurs' => Secteur::latest()->get(),
			'unites' => Unite::latest()->get()
        ]);
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
        //For demo purposes only. When creating user or inviting a user
        // you should create a generated random password and email it to the user
        $user->create(array_merge($request->validated(), [
            'password' => 'test' 
        ]));

        return redirect()->route('users.index')
            ->withSuccess(__('User created successfully.'));
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
			'specialites' => Specialite::latest()->get(),
			'diplomes' => Diplome::latest()->get(),
			'secteurs' => Secteur::latest()->get(),
			'unites' => Unite::latest()->get()
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
        $user->update($request->validated());

        $user->syncRoles($request->get('role'));
		
		$grade = Grade::where('id',intval($request->get('grade')))->first();
		$user->grade()->associate($grade);

		$specialite = Specialite::where('id',intval($request->get('specialite')))->first();
		$user->specialite()->associate($specialite);

		$diplome = Diplome::where('id',intval($request->get('diplome')))->first();
		$user->diplome()->associate($diplome);

		$unite_destination = Unite::where('id',intval($request->get('unite_destination')))->first();
		$user->unite_destination()->associate($unite_destination);

		$secteur = Secteur::where('id',intval($request->get('secteur')))->first();
		$user->secteur()->associate($secteur);
		
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