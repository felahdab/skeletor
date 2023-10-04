<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Groupement;
use App\Models\Service;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listservice = Service::select('services.id AS id', 'services.service_libcourt', 'services.service_liblong', 'groupements.groupement_libcourt', 'groupements.groupement_liblong')
        ->join('groupements','groupements.id','=','services.groupement_id')
        ->orderBy('id')
        ->get();

        return view('services.index', [
            'listservice' => $listservice
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groupement = Groupement::all();
        return view('services.create', ['groupement' => $groupement]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreServiceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreServiceRequest $request)
    {
        // Valider les données du formulaire
        $validatedData = $request->validate([
            'service_libcourt' => 'required',
            'service_libcourt' => 'required',
            'groupement_libcourt' => 'required',
        ]);
        
        // Créer un nouveau service
        $service = new Service();
        $service->service_libcourt = $request->service_libcourt;
        $service->service_liblong = $request->service_liblong;
        $groupement = Groupement::where('groupement_libcourt',$request->groupement_libcourt)->first(['id']);
        $service->groupement_id= $groupement->id;
        $service->save();

        // Rediriger vers la route 'services.index'
        return redirect()->route('services.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        $groupement = Groupement::where('id',$service->groupement_id)->first(['groupement_libcourt']);
        return view('services.show', ['service' => $service], [ 'groupement' => $groupement]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        $groupement = Groupement::all();
        return view('services.edit', ['service' => $service], ['groupement' => $groupement] );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateServiceRequest  $request
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateServiceRequest $request, Service $service)
    {
        $query=Service::where('id', $service->id);
        if ( $query->count() == 1)
        {
            $update = $query->first();
            $update->service_libcourt=$request->input('service_libcourt');
            $update->service_liblong=$request->input('service_liblong');
            $groupement = Groupement::where('groupement_libcourt', $request->input('groupement_libcourt'))->first(['id']);
            $update->groupement_id=$groupement->id;
            $update->save();
        }
        return redirect()->route('services.index', $update);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('services.index')
            ->withSuccess(__('Service supprimé avec succès.'));
    }
}
