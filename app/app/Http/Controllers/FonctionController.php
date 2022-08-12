<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFonctionRequest;
use App\Http\Requests\UpdateFonctionRequest;
use App\Models\Fonction;
use App\Models\TypeFonction;
use App\Models\Compagnonage;

use Illuminate\Http\Request;

class FonctionController extends Controller
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
            $fonctions = Fonction::where('fonction_libcourt', 'LIKE', '%'.$filter.'%')->orderBy('fonction_libcourt')->paginate(10);
        } else {
            $fonctions = Fonction::orderBy('fonction_libcourt')->paginate(10);
        }
        
        return view('fonctions.index', ['fonctions' => $fonctions ] );
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
     * @param  \App\Http\Requests\StoreFonctionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFonctionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Fonction  $fonction
     * @return \Illuminate\Http\Response
     */
    public function show(Fonction $fonction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Fonction  $fonction
     * @return \Illuminate\Http\Response
     */
    public function edit(Fonction $fonction)
    {
        $fonctions = Fonction::orderBy('fonction_libcourt')->get();
        $typefonctions = TypeFonction::orderBy('typfonction_libcourt')->get();
        return view('fonctions.edit', ['fonction'       => $fonction, 
                                        'fonctions'     => $fonctions,
                                        'typefonctions' => $typefonctions] );
    }
    
    public function choisircompagnonage(Request $request, Fonction $fonction)
    {
        if ($request->has('filter') )
        {
            $filter = $request->input('filter');
            $compagnonages = Compagnonage::where('comp_libcourt', 'LIKE', '%'.$filter.'%')->orderBy('comp_libcourt')->get()    ;
        } 
        else 
        {
            $filter='';
            $compagnonages = Compagnonage::orderBy('comp_libcourt')->get();
        }
        $compagnonages = $compagnonages->diff($fonction->compagnonages()->get());
        
        return view('fonctions.choisircompagnonage', [ 'fonction' => $fonction,
                                                'compagnonages' => $compagnonages,
                                                'filter'    => $filter]);
    }
    
    public function ajoutercompagnonage(Request $request, Fonction $fonction)
    {
        $compagnonage_id = intval($request->input('compagnonage_id', 0));
        $query = Compagnonage::where('id', $compagnonage_id)->get();
        if ($query->count() == 1)
        {
            $compagnonage = $query->first();
            $fonction->compagnonages()->attach($compagnonage);
        }
        return redirect()->route('fonctions.edit', ['fonction'   => $fonction]);
    }
    
    public function removecompagnonage(Request $request, Fonction $fonction)
    {
        $comp_id = intval($request->input('compagnonage_id', 0));
        $query = Compagnonage::where('id', $comp_id)->get();
        if ($query->count() == 1)
        {
            $compagnonage = $query->first();
            $fonction->compagnonages()->detach($compagnonage);
        }
        return redirect()->route('fonctions.edit', ['fonction'   => $fonction]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFonctionRequest  $request
     * @param  \App\Models\Fonction  $fonction
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFonctionRequest $request, Fonction $fonction)
    {
        // var_dump($request);
        $fonction->fonction_libcourt=$request->fonction['fonction_libcourt'];
        $fonction->fonction_liblong=$request->fonction['fonction_liblong'];
        $fonction->typefonction_id = $request->fonction['typefonction_id'];
        if (array_key_exists('fonction_lache', $request->fonction))
            $fonction->fonction_lache = true;
        else
            $fonction->fonction_lache = false;
        if (array_key_exists('fonction_double', $request->fonction))
            $fonction->fonction_double = true;
        else
            $fonction->fonction_double = false;
        $fonction->save();
        
        return redirect()->route('fonctions.edit', $fonction);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Fonction  $fonction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fonction $fonction)
    {
        //
    }
}
