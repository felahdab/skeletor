<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSecteurRequest;
use App\Http\Requests\UpdateSecteurRequest;
use App\Models\Secteur;
use App\Models\Service;

class SecteurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('secteurs.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $service = Service::all();
        return view('secteurs.create', ['service' => $service]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSecteurRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSecteurRequest $request)
    {
        // Valider les données du formulaire
        $validatedData = $request->validate([
            'secteur_libcourt' => 'required',
            'secteur_libcourt' => 'required',
            'service_libcourt' => 'required',
        ]);
        
        // Créer un nouveau secteur
        $secteur = new Secteur();
        $secteur->secteur_libcourt = $request->secteur_libcourt;
        $secteur->secteur_liblong = $request->secteur_liblong;
        $service = Service::where('service_libcourt',$request->service_libcourt)->first(['id']);
        $secteur->service_id= $service->id;
        $secteur->save();

        // Rediriger vers la route 'secteurs.index'
        return redirect()->route('secteurs.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Secteur  $secteur
     * @return \Illuminate\Http\Response
     */
    public function show(Secteur $secteur)
    {
        $service = Service::where('id',$secteur->service_id)->first(['service_libcourt']);
        return view('secteurs.show', ['secteur' => $secteur], [ 'service' => $service]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Secteur  $secteur
     * @return \Illuminate\Http\Response
     */
    public function edit(Secteur $secteur)
    {
        $service = Service::all();
        return view('secteurs.edit', ['secteur' => $secteur], ['service' => $service] );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSecteurRequest  $request
     * @param  \App\Models\Secteur  $secteur
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSecteurRequest $request, Secteur $secteur)
    {
        $query=Secteur::where('id', $secteur->id);
        if ( $query->count() == 1)
        {
            $update = $query->first();
            $update->secteur_libcourt=$request->input('secteur_libcourt');
            $update->secteur_liblong=$request->input('secteur_liblong');
            $service = Service::where('service_libcourt', $request->input('service_libcourt'))->first(['id']);
            $update->service_id=$service->id;
            $update->save();
        }
        return redirect()->route('secteurs.index', $update);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Secteur  $secteur
     * @return \Illuminate\Http\Response
     */
    public function destroy(Secteur $secteur)
    {
        $secteur->delete();

        return redirect()->route('secteurs.index')
            ->withSuccess(__('Secteur supprimé avec succès.'));
    }
}
