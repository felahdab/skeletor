<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePasswdRequest;
use App\Models\User;

class ChangeUserPassword extends Controller
{
    public function index(User $user)
    {
        return view('changepasswd.index', [
            'user' => $user,
        ]);
    }

    public function store(User $user, UpdatePasswdRequest $request)
    {
        $user->setPasswordAttribute($request->input('password'));
        $user->save();

        return redirect()->route('home.index')
            ->withSuccess(__('Mot de passe modifié.'))
        ;
    }
}
