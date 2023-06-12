<?php

namespace Modules\Transformation\Http\Controllers;

use App\Service\RecalculerTransformationService;

use Modules\Transformation\Http\Requests\StoreCompagnonageRequest;
use Modules\Transformation\Entities\Compagnonage;
use App\Http\Controllers\Controller;
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
        
        return view('transformation::compagnonages.index', ['compagnonages' => $comps ,
                                            'filter'        => $filter] );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('transformation::compagnonages.create' );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCompagnonageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCompagnonageRequest $request)
    {
        $comp=new Compagnonage;
        $comp->comp_libcourt = $request->comp['comp_libcourt'];
        $comp->comp_liblong = $request->comp['comp_liblong'];
        $comp->save();
        return redirect()->route('compagnonages.edit', $comp);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Compagnonage  $compagnonage
     * @return \Illuminate\Http\Response
     */
    public function show(Compagnonage $compagnonage)
    {
       
        return view('transformation::compagnonages.show', ['compagnonage'   => $compagnonage] );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Compagnonage  $compagnonage
     * @return \Illuminate\Http\Response
     */
    public function edit(Compagnonage $compagnonage)
    {
        return view('transformation::compagnonages.edit', ['compagnonage'   => $compagnonage] );
    }
    public function choisirtache(Request $request, Compagnonage $compagnonage)
    {
        
        $taches = Tache::orderBy('tache_libcourt')->get();
        $taches = $taches->diff($compagnonage->taches()->get());
        
        return view('transformation::compagnonages.choisirtache', [ 'compagnonage' => $compagnonage,
                                                'taches' => $taches]);
    }
    
    public function ajoutertache(Request $request, Compagnonage $compagnonage)
    {
        $tache_id = intval($request->input('tache_id', 0));
        $query = Tache::where('id', $tache_id)->get();
        if ($query->count() == 1)
        {
            $tache = $query->first();
            $compagnonage->taches()->attach($tache);
            RecalculerTransformationService::handle();
        }
        return redirect()->route('compagnonages.edit', ['compagnonage'   => $compagnonage]);
        // return view('compagnonages.edit', ['compagnonage'   => $compagnonage] );
    }
    
    public function removetache(Request $request, Compagnonage $compagnonage, Tache $tache)
    {
        // $tache_id = intval($request->input('tache_id', 0));
        // $query = Tache::where('id', $tache_id)->get();
        // if ($query->count() == 1)
        // {
        //     $tache = $query->first();
            $compagnonage->taches()->detach($tache);
            RecalculerTransformationService::handle();
        // }
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
    public function update(Request $request, Compagnonage $compagnonage)
    {
        
        $compagnonage->comp_libcourt=$request->comp['comp_libcourt'];
        $compagnonage->comp_liblong=$request->comp['comp_liblong'];

        $taches = $compagnonage->taches;
        //ddd(array_flip($request->sort_order));
        foreach(array_flip($request->sort_order) as $id => $ordre)
        {
            $w = $taches->find($id)->pivot;
            $w->ordre = $ordre;
            $w->save();
        }
        $compagnonage->save();
        
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
        $compagnonage->delete();
        RecalculerTransformationService::handle();
        return redirect()->route('compagnonages.index');
    }
}
