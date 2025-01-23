<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Http\Requests\UpdatePasswdRequest;

class ChangeUserPassword extends Controller
{
    public function index(User $user) 
    {
        return view('changepasswd.index', [
            'user' => $user
        ]);
    }
	
	public function store(User $user, UpdatePasswdRequest $request) 
    {
		
		$user->setPasswordAttribute($request->input('password'));
		$user->save();
		
        return redirect()->route('home.index')
            ->withSuccess(__('Mot de passe modifié.'));
    }
}
