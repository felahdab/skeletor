<?php

namespace App\Http\Controllers;

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
    public function index()
    {
		$sousobjectifs = SousObjectif::orderBy('ssobj_lib')->get();
        return view('sousobjectifs.index', compact('sousobjectifs'));
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
		$ssobj->lieu_id = 3;
		
		$ssobj->save();
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
		foreach ($request->sous_objectifs as $ssobj)
		{
			$current_ssobj = SousObjectif::where('id', $ssobj['id']);
			$current_ssobj->update($ssobj);
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
		return redirect()->route('objectifs.edit', $request['objectif_id']);
    }
}
