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
			$taches = Tache::where('tache_libcourt', 'LIKE', '%'.$filter.'%')->orderBy('tache_libcourt')->get()	;
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
	
	public function ajoutercompagnonage(Request $request, Fonction $fonction)
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
	
	public function removecompagnonage(Request $request, Fonction $fonction)
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
     * @param  \App\Http\Requests\UpdateFonctionRequest  $request
     * @param  \App\Models\Fonction  $fonction
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFonctionRequest $request, Fonction $fonction)
    {
        //
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
