<?php

namespace Modules\Transformation\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Transformation\Services\RecalculerTransformationService;

use App\Http\Requests\StoreTacheRequest;
use App\Http\Requests\UpdateTacheRequest;
use Modules\Transformation\Entities\Tache;
use Modules\Transformation\Entities\Objectif;

use Illuminate\Http\Request;

class TacheController extends Controller
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
            $taches = Tache::where('tache_libcourt', 'LIKE', '%'.$filter.'%')->orderBy('tache_libcourt')->paginate(10);
        } else {
            $filter = "";
            $taches = Tache::orderBy('tache_libcourt')->paginate(10);
        }
        
        return view('transformation::taches.index', ['taches' => $taches,
                                     'filter' => $filter] );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('transformation::taches.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTacheRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTacheRequest $request)
    {
        $tache=new Tache;
        $tache->tache_libcourt = $request->tache['tache_libcourt'];
        $tache->tache_liblong = $request->tache['tache_liblong'];
        $tache->save();
        return redirect()->route('taches.edit', $tache);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tache  $tache
     * @return \Illuminate\Http\Response
     */
    public function show(Tache $tach)
    {
        return view('transformation::taches.show',   ['tache'   => $tach ]  );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tache  $tache
     * @return \Illuminate\Http\Response
     */
    public function edit(Tache $tach)
    {
        return view('transformation::taches.edit', ['tache'   => $tach] );
    }
    
    public function choisirobjectif(Request $request, Tache $tach)
    {
        return view('transformation::taches.choisirobjectif', [ 'tache' => $tach]);
    }
    
    public function ajouterobjectif(Request $request, Tache $tach, Objectif $objectif)
    {
        $tach->objectifs()->attach($objectif);
        RecalculerTransformationService::handle();
        $tache = $tach;

        //maj du pivot pour ordre  
        $nb_ordre = $tach->objectifs()->count() + 1;
        $maj = $tach->objectifs()
                        ->where('tache_id',$tache->id)
                        ->where('objectif_id',$objectif->id)
                        ->update(["ordre" => $nb_ordre]);
        
        return redirect()->route('taches.edit', $tache);
    }
    
    public function removeobjectif(Request $request, Tache $tach, Objectif $objectif)
    {
        
        $tach->objectifs()->detach($objectif);
        RecalculerTransformationService::handle();
        $tache = $tach;
        return redirect()->route('taches.edit', $tache);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTacheRequest  $request
     * @param  \App\Models\Tache  $tache
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTacheRequest $request, Tache $tach)
    {
        $tach->tache_libcourt = $request->tache['tache_libcourt'];
        $tach->tache_liblong  = $request->tache['tache_liblong'];
        $objectifs = $tach->objectifs;
        foreach(array_flip($request->sort_order) as $id => $ordre)
        {
            $w = $objectifs->find($id)->pivot;
            $w->ordre = $ordre;
            $w->save();
        }
        $tach->save();
        return redirect()->route('taches.edit', $tach);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tache  $tache
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tache $tach)
    {
        $tach->delete();
        RecalculerTransformationService::handle();
        return redirect()->route('taches.index')->withSuccess("Tache supprimee");
    }
}
