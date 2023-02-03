<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTacheRequest;
use App\Http\Requests\UpdateTacheRequest;
use App\Models\Tache;
use App\Models\Objectif;

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
        
        return view('taches.index', ['taches' => $taches,
                                     'filter' => $filter] );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('taches.create');
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
        return view('taches.show',   ['tache'   => $tach ]  );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tache  $tache
     * @return \Illuminate\Http\Response
     */
    public function edit(Tache $tach)
    {
        return view('taches.edit', ['tache'   => $tach] );
    }
    
    public function choisirobjectif(Request $request, Tache $tach)
    {
        $objectifs = Objectif::orderBy('objectif_libcourt')->get();
        $objectifs = $objectifs->diff($tach->objectifs()->get());
        
        return view('taches.choisirobjectif', [ 'tache'     => $tach,
                                                'objectifs' => $objectifs]);
    }
    
    public function ajouterobjectif(Request $request, Tache $tach)
    {
        $objectif_id = intval($request->input('objectif_id', 0));
        $query = Objectif::where('id', $objectif_id)->get();
        if ($query->count() == 1)
        {
            $objectif = $query->first();
            $tach->objectifs()->attach($objectif);
        }
        $tache = $tach;
        return redirect()->route('taches.edit', $tache);
    }
    
    public function removeobjectif(Request $request, Tache $tach)
    {
        $objectif_id = intval($request->input('objectif_id', 0));
        $query = Objectif::where('id', $objectif_id)->get();
        if ($query->count() == 1)
        {
            $objectif = $query->first();
            $tach->objectifs()->detach($objectif);
        }
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
    public function update(UpdateTacheRequest $request, Tache $tache)
    {
        $tache_id= intval($request->input('tache')['id']);
        $query=Tache::where('id', $tache_id);
        if ( $query->count() == 1)
        {
            $tache = $query->first();
            $tache->tache_libcourt=$request->tache['tache_libcourt'];
            $tache->tache_liblong=$request->tache['tache_liblong'];
            $tache->save();
        }
        return redirect()->route('taches.edit', $tache);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tache  $tache
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tache $tache)
    {
        $tache->delete();
        return redirect()->route('taches.index');
    }
}
