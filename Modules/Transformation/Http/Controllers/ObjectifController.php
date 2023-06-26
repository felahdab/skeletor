<?php

namespace Modules\Transformation\Http\Controllers;

use Modules\Transformation\Http\Requests\StoreObjectifRequest;
use Modules\Transformation\Http\Requests\UpdateObjectifRequest;

use Modules\Transformation\Services\RecalculerTransformationService;

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
        return redirect()->route('transformation::objectifs.edit', $objectif);
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
        $objectif->objectif_libcourt=$request->objectif['objectif_libcourt'];
        $objectif->objectif_liblong=$request->objectif['objectif_liblong'];
        $sous_objectifs = $objectif->sous_objectifs;
        foreach(array_flip($request->sort_order) as $id => $ordre)
        {
            $ssobj = $sous_objectifs->find($id);
            $ssobj->ordre = $ordre;
            $ssobj->ssobj_lib = $request->sous_objectifs[$id]['ssobj_lib'];
            $ssobj->ssobj_lienurl = $request->sous_objectifs[$id]['ssobj_lienurl'];
            $ssobj->ssobj_coeff = $request->sous_objectifs[$id]['ssobj_coeff'];
            $ssobj->ssobj_duree = $request->sous_objectifs[$id]['ssobj_duree'];
            $ssobj->lieu_id = $request->sous_objectifs[$id]['lieu_id'];
            $ssobj->save();
        }
        $objectif->save();

        return redirect()->route('transformation::objectifs.edit', $objectif);
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
        return redirect()->route('transformation::objectifs.index');
    }
}
