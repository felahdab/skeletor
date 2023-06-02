<?php

namespace App\Http\Controllers;

use App\Service\RecalculerTransformationService;

use Illuminate\Http\Request;

use App\Http\Requests\StoreSousObjectifRequest;
use App\Http\Requests\UpdateSousObjectifRequest;
use App\Models\SousObjectif;

class SousObjectifController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $sousobjectifs = SousObjectif::orderBy('ssobj_lib')->get();
        // return view('sousobjectifs.index', compact('sousobjectifs'));
        
        if ($request->has('filter') )
        {
            $filter = $request->input('filter');
            $sousobjectifs = SousObjectif::where('ssobj_lib', 'LIKE', '%'.$filter.'%')->orderBy('ssobj_lib')->paginate(10);
        } else {
            $filter = "";
            $sousobjectifs = SousObjectif::orderBy('ssobj_lib')->paginate(10);
        }
        
        return view('sousobjectifs.index', ['sousobjectifs' => $sousobjectifs ,
                                            'filter'        => $filter] );
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
     * @param  \App\Http\Requests\StoreSousObjectifRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSousObjectifRequest $request)
    {
        $ssobj = new SousObjectif;
        $ssobj->objectif_id = intval($request['objectif_id']);
        $ssobj->ssobj_lib = 'Nouveau sous objectif a configurer';
        $ssobj->lieu_id = 3; // par défaut...
        
        $ssobj->save();
        RecalculerTransformationService::handle();
        return redirect()->route('objectifs.edit', $request['objectif_id']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SousObjectif  $sousObjectif
     * @return \Illuminate\Http\Response
     */
    public function show(SousObjectif $sousObjectif)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SousObjectif  $sousObjectif
     * @return \Illuminate\Http\Response
     */
    public function edit(SousObjectif $sousObjectif)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSousObjectifRequest  $request
     * @param  \App\Models\SousObjectif  $sousObjectif
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSousObjectifRequest $request, SousObjectif $sousObjectif)
    {
        //
    }
    
    public function multipleupdate(Request $request)
    {
        $sort_order = array_flip($request->input('sort_order'));

        foreach ($request->sous_objectifs as $ordre => $ssobj)
        {
            $current_ssobj = SousObjectif::where('id', $ssobj['id']);
            $ssobj["ordre"]=$sort_order[$ssobj['id']];
            $current_ssobj->update($ssobj);

            RecalculerTransformationService::handle();
        }
        return redirect()->route('objectifs.edit', $request['objectif_id']);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SousObjectif  $sousObjectif
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, SousObjectif $sousObjectif)
    {
        $sousObjectif->delete();
        RecalculerTransformationService::handle();
        return redirect()->route('objectifs.edit', $request['objectif_id']);
    }
}
