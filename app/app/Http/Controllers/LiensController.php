<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Liens;

class LiensController extends Controller
{
    public function index(Request $request)
    {
        return view('liens.index');
    }

    public function create()
    {
        return view('liens.create');
        //
    }

    public function store(Request $request)
    {
        return view('liens.store');
        //
    }
    public function edit()
    {
        return view('liens.edit');
    }

}
