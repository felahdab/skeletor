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
        $listgroupement = Groupement::all();
        return view('groupement.index', [
            'listgroupement' => $listgroupement
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('groupement.create', [
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreGroupementRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGroupementRequest $request)
    {
        $validatedData = $request->validate([
            'groupement_libcourt' => 'required',
            'groupement_liblong' => 'required',
        ]);
        // Créer un nouveau groupement
        $groupement = new Groupement();
        $groupement->groupement_libcourt = $request->groupement_libcourt;
        $groupement->groupement_liblong = $request->groupement_liblong;
        $groupement->save();

        // Rediriger vers la route 'groupement.index'
        return redirect()->route('groupement.index'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Groupement  $groupement
     * @return \Illuminate\Http\Response
     */
    public function show(Groupement $groupement)
    {
        return view('groupement.show', ['groupement' => $groupement]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Groupement  $groupement
     * @return \Illuminate\Http\Response
     */
    public function edit(Groupement $groupement)
    {
        return view('groupement.edit', ['groupement' => $groupement]);
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
        $query=Groupement::where('id', $groupement->id);
        if ( $query->count() == 1)
        {
            $update = $query->first();
            $update->groupement_libcourt=$request->input('groupement_libcourt');
            $update->groupement_liblong=$request->input('groupement_liblong');
            $update->save();
        }
        return redirect()->route('groupement.index', $update);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Groupement  $groupement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Groupement $groupement)
    {
        $groupement->delete();

        return redirect()->route('groupement.index')
            ->withSuccess(__('Groupement supprimé avec succès.'));
    } 
}
