<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompagnonageRequest;
use App\Http\Requests\UpdateCompagnonageRequest;
use App\Models\Compagnonage;
use App\Models\Tache;

use Illuminate\Http\Request;

class CompagnonageController extends Controller
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
            $comps = Compagnonage::where('comp_libcourt', 'LIKE', '%'.$filter.'%')->orderBy('comp_libcourt')->paginate(10);
        } else {
            $filter = "";
            $comps = Compagnonage::orderBy('comp_libcourt')->paginate(10);
        }
        
        return view('compagnonages.index', ['compagnonages' => $comps ,
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
       
        return view('compagnonages.show', ['compagnonage'   => $compagnonage] );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Compagnonage  $compagnonage
     * @return \Illuminate\Http\Response
     */
    public function edit(Compagnonage $compagnonage)
    {
        return view('compagnonages.edit', ['compagnonage'   => $compagnonage] );
    }
    public function choisirtache(Request $request, Compagnonage $compagnonage)
    {
        if ($request->has('filter') )
        {
            $filter = $request->input('filter');
            $taches = Tache::where('tache_libcourt', 'LIKE', '%'.$filter.'%')->orderBy('tache_libcourt')->get()    ;
        } 
        else 
        {
            $filter='';
            $taches = Tache::orderBy('tache_libcourt')->get();
        }
        $taches = $taches->diff($compagnonage->taches()->get());
        
        return view('compagnonages.choisirtache', [ 'compagnonage' => $compagnonage,
                                                'taches' => $taches,
                                                'filter'    => $filter]);
    }
    
    public function ajoutertache(Request $request, Compagnonage $compagnonage)
    {
        $tache_id = intval($request->input('tache_id', 0));
        $query = Tache::where('id', $tache_id)->get();
        if ($query->count() == 1)
        {
            $tache = $query->first();
            $compagnonage->taches()->attach($tache);
        }
        return redirect()->route('compagnonages.edit', ['compagnonage'   => $compagnonage]);
        // return view('compagnonages.edit', ['compagnonage'   => $compagnonage] );
    }
    
    public function removetache(Request $request, Compagnonage $compagnonage)
    {
        $tache_id = intval($request->input('tache_id', 0));
        $query = Tache::where('id', $tache_id)->get();
        if ($query->count() == 1)
        {
            $tache = $query->first();
            $compagnonage->taches()->detach($tache);
        }
        return redirect()->route('compagnonages.edit', ['compagnonage'   => $compagnonage]);
        // return view('compagnonages.edit', ['compagnonage'   => $compagnonage] );
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
        $comp_id= intval($request->input('comp')['id']);
        $query=Compagnonage::where('id', $comp_id);
        if ( $query->count() == 1)
        {
            $comp = $query->first();
            $comp->comp_libcourt=$request->comp['comp_libcourt'];
            $comp->comp_liblong=$request->comp['comp_liblong'];
            $comp->save();
        }
        return redirect()->route('compagnonages.edit', $compagnonage);
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
