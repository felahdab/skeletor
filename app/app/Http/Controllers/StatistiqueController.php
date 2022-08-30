<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;

use Illuminate\Http\Request;

class StatistiqueController extends Controller
{
    public function index(Request $request) 
    {
        if ($request->has("month"))
            $month = $request["month"];
        else
            $month = date("Y-m-1");
        ddd($month);
        return view('statistiques.index', ['month' => $month]);
    }
}
