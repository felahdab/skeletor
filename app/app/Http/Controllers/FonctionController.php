<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFonctionRequest;
use App\Http\Requests\UpdateFonctionRequest;
use App\Models\Fonction;

class FonctionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return "FonctionController index";
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
     * @param  \App\Http\Requests\StoreFonctionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFonctionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Fonction  $fonction
     * @return \Illuminate\Http\Response
     */
    public function show(Fonction $fonction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Fonction  $fonction
     * @return \Illuminate\Http\Response
     */
    public function edit(Fonction $fonction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFonctionRequest  $request
     * @param  \App\Models\Fonction  $fonction
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFonctionRequest $request, Fonction $fonction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Fonction  $fonction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fonction $fonction)
    {
        //
    }
}
