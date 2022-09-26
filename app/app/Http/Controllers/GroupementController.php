<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGroupementRequest;
use App\Http\Requests\UpdateGroupementRequest;
use App\Models\Groupement;

class GroupementController extends Controller
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
     * @param  \App\Http\Requests\StoreGroupementRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGroupementRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Groupement  $groupement
     * @return \Illuminate\Http\Response
     */
    public function show(Groupement $groupement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Groupement  $groupement
     * @return \Illuminate\Http\Response
     */
    public function edit(Groupement $groupement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateGroupementRequest  $request
     * @param  \App\Models\Groupement  $groupement
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGroupementRequest $request, Groupement $groupement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Groupement  $groupement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Groupement $groupement)
    {
        //
    }
}
