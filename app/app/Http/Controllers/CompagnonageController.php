<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompagnonageRequest;
use App\Http\Requests\UpdateCompagnonageRequest;
use App\Models\Compagnonage;

class CompagnonageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreCompagnonageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCompagnonageRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Compagnonage  $compagnonage
     * @return \Illuminate\Http\Response
     */
    public function show(Compagnonage $compagnonage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Compagnonage  $compagnonage
     * @return \Illuminate\Http\Response
     */
    public function edit(Compagnonage $compagnonage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCompagnonageRequest  $request
     * @param  \App\Models\Compagnonage  $compagnonage
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCompagnonageRequest $request, Compagnonage $compagnonage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Compagnonage  $compagnonage
     * @return \Illuminate\Http\Response
     */
    public function destroy(Compagnonage $compagnonage)
    {
        //
    }
}
