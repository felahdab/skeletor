<?php

namespace Modules\Transformation\Http\Controllers;

use Modules\Transformation\Http\Requests\StoreObjectifRequest;
use Modules\Transformation\Http\Requests\UpdateObjectifRequest;

use App\Service\RecalculerTransformationService;

use Illuminate\Http\Request;

use Modules\Transformation\Entities\Objectif;
use App\Http\Controllers\Controller;
use App\Models\Lieu;

class ObjectifController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('filter') )
        {
            $filter = $request->input('filter');
            $objectifs = Objectif::where('objectif_libcourt', 'LIKE', '%'.$filter.'%')->orderBy('objectif_libcourt')->paginate(10);
        } else {
            $filter='';
            $objectifs = Objectif::orderBy('objectif_libcourt')->paginate(10);
        }
        
        return view('transformation::objectifs.index', ['objectifs' => $objectifs,
                                        'filter'    => $filter] );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('transformation::objectifs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreObjectifRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreObjectifRequest $request)
    {
        $objectif=new Objectif;
        $objectif->objectif_libcourt = $request->objectif['objectif_libcourt'];
        $objectif->objectif_liblong = $request->objectif['objectif_liblong'];
        $objectif->save();
        return redirect()->route('objectifs.edit', $objectif);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Objectif  $objectif
     * @return \Illuminate\Http\Response
     */
    public function show(Objectif $objectif)
    {
        $lieux = Lieu::orderBy('lieu_liblong')->get();
        return view('transformation::objectifs.show',   ['objectif'   => $objectif,
                                        'lieux'     => $lieux] );
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
        return view('transformation::objectifs.edit', ['objectif'   => $objectif, 
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
        $objectif_id= intval($request->input('objectif')['id']);
        $query=Objectif::where('id', $objectif_id);
        if ( $query->count() == 1)
        {
            $objectif = $query->first();
            $objectif->objectif_libcourt=$request->objectif['objectif_libcourt'];
            $objectif->objectif_liblong=$request->objectif['objectif_liblong'];
            $objectif->save();
        }
        return redirect()->route('objectifs.edit', $objectif);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Objectif  $objectif
     * @return \Illuminate\Http\Response
     */
    public function destroy(Objectif $objectif)
    {
        $objectif->delete();
        RecalculerTransformationService::handle();
        return redirect()->route('objectifs.index');
    }
}
