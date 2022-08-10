<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreObjectifRequest;
use App\Http\Requests\UpdateObjectifRequest;
use App\Models\Objectif;
use App\Models\Lieu;

class ObjectifController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $objectifs = Objectif::orderBy('objectif_libcourt')->get();
        return view('objectifs.index', ['objectifs' => $objectifs ] );
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
     * @param  \App\Http\Requests\StoreObjectifRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreObjectifRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Objectif  $objectif
     * @return \Illuminate\Http\Response
     */
    public function show(Objectif $objectif)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Objectif  $objectif
     * @return \Illuminate\Http\Response
     */
    public function edit(Objectif $objectif)
    {
        $objectifs = Objectif::orderBy('objectif_libcourt')->get();
		$lieux = Lieu::orderBy('lieu_liblong')->get();
        return view('objectifs.edit', ['objectif'   => $objectif, 
										'objectifs' => $objectifs,
										'lieux'     => $lieux] );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateObjectifRequest  $request
     * @param  \App\Models\Objectif  $objectif
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateObjectifRequest $request, Objectif $objectif)
    {
        var_dump($request->input());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Objectif  $objectif
     * @return \Illuminate\Http\Response
     */
    public function destroy(Objectif $objectif)
    {
        //
    }
}
