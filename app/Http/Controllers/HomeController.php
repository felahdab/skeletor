<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Nwidart\Modules\Facades\Module;

class HomeController extends Controller
{
    public function index() 
    {
        return view('home.index');
    }
}