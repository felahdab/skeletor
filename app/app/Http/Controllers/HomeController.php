<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Stage;
use App\Models\User;

class HomeController extends Controller
{
    public function index() 
    {
        $stages = Stage::all();
        $users = User::local()->get();
        
        return view('home.index', ['stages' => $stages,
                                   'users'  => $users]);
    }
}