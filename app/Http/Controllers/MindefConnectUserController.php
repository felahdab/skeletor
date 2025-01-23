<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMindefConnectUserRequest;
use App\Http\Requests\UpdateMindefConnectUserRequest;
use App\Models\MindefConnectUser;
use Illuminate\Http\Request;

use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Models\Secteur;
use App\Models\Specialite;
use App\Models\Diplome;
use App\Models\Grade;
use App\Models\Unite;

use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;

use App\Service\PossibleUniteService;

use App\Events\UnUtilisateurDoitEtreRestaureEvent;


class MindefConnectUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mcusers = MindefConnectUser::paginate(10);
        
        return view('mindefconnect.index', ['mcusers' => $mcusers]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMindefConnectUserRequest  $request
     * @return \Illuminate\Http\Response
     */
     
    function generateRandomString($length = 10) {
       return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }
    
    public function store(MindefConnectUser $user, StoreMindefConnectUserRequest $request)
    {
        $newUser = User::create(array_merge($request->input(), [ "password" =>$this->generateRandomString()]));
        $newUser->display_name=$newUser->displayString();
        $newUser->admin = false;  
        if ($request->has('admin'))
            $newUser->admin = true;       
        $newUser->save();
        
        $newUser->syncRoles($request->get('role'));
        
        if (is_null($request->get('role')) or ! in_array("user", $request->get('role')))
        {
            $roletransfo = Role::where("name", "user")->get()->first();
            $newUser->roles()->attach($roletransfo);
        }
        
        $user->delete();

        Mail::to($newUser->email)
            ->queue(new WelcomeMail($newUser));

        return redirect()->route('mindefconnect.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MindefConnectUser  $mindefConnectUser
     * @return \Illuminate\Http\Response
     */
    public function show(MindefConnectUser $mindefConnectUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MindefConnectUser  $mindefConnectUser
     * @return \Illuminate\Http\Response
     */
    public function edit(MindefConnectUser $User)
    {
        $userGrade = strtoupper($User->rank);
        $possibleGrade = Grade::where("grade_liblong", "like", $userGrade)->get()->first();
        
        $possibleUnite= PossibleUniteService::possibleunite($User->main_department_number);

        $cpte_exist=false;
        if (User::withTrashed()->where ("email", $User->email)->get()->first()) {$cpte_exist=true;}            
        
        return view('mindefconnect.edit', ['mcuser' => $User,
                                    'roles' => Role::latest()->get(),
                                    'grades' => Grade::orderBy('ordre_classmt', 'asc')->get(),
                                    'specialites' => Specialite::orderBy('specialite_libcourt', 'asc')->get(),
                                    'diplomes' => Diplome::latest()->get(),
                                    'secteurs' => Secteur::orderBy('secteur_libcourt', 'asc')->get(),
                                    'unites' => Unite::orderBy('unite_libcourt', 'asc')->get(),
                                    'possibleGrade' => $possibleGrade,
                                    'possibleUnite' => $possibleUnite,
                                    'cpte_exist' => $cpte_exist
                                ]);
    }

    public function comebacklater()
    {
        return view('auth.comebacklater');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMindefConnectUserRequest  $request
     * @param  \App\Models\MindefConnectUser  $mindefConnectUser
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMindefConnectUserRequest $request, MindefConnectUser $mindefConnectUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MindefConnectUser  $mindefConnectUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(MindefConnectUser $user)
    {
        $user->delete();
        return redirect()->route('mindefconnect.index');
    }
    public function conservcpte(MindefConnectUser $mcuser)
    {
        UnUtilisateurDoitEtreRestaureEvent::dispatch($mcuser->email, true);
        $mcuser->delete();

        return redirect()->route('mindefconnect.index')
            ->withSuccess(__('Utilisateur restauré avec succès.'));
    }
    public function effacecpte(MindefConnectUser $mcuser)
    {
        UnUtilisateurDoitEtreRestaureEvent::dispatch($mcuser->email, false);
        $mcuser->delete();
        
        return redirect()->route('mindefconnect.index')
            ->withSuccess(__('Utilisateur restauré avec succès.'));
    }
}
