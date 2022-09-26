<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class ChangeUserCurrentRole extends Controller
{
    public function index(User $user) 
    {
        $user = auth()->user();
        return view('currentrole.index', [
            'user' => $user,
            'userRole' => $user->roles
        ]);
    }
    
    /**
     * Store the new current role for the user
     * 
     * @param StoreUserRequest $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) 
    {
        #var_dump($request->role);

        $request->session()->put('current_role', $request->role);
        $request->session()->save();

        return redirect()->route('home.index')
            ->withSuccess(__('Role actif modifié.'));
    }
}
