<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFonctionRequest;
use App\Http\Requests\UpdateFonctionRequest;
use App\Models\Fonction;
use App\Models\TypeFonction;
use App\Models\Compagnonage;
use App\Models\Tache;
use App\Models\SousObjectif;
use App\Models\Stage;
use App\Models\User;

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
            $filter="";
            $fonctions = Fonction::with('type_fonction')->orderBy('fonction_libcourt')->paginate(10);
        }
        
        return view('fonctions.index', ['fonctions' => $fonctions ,
                                        'filter'    => $filter] );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $typefonctions = TypeFonction::orderBy('typfonction_libcourt')->get();
        return view('fonctions.create' , ['typefonctions' => $typefonctions]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFonctionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFonctionRequest $request)
    {
        // ddd($request);
        $fonction=new Fonction;
        $fonction->fonction_libcourt = $request->fonction['fonction_libcourt'];
        $fonction->fonction_liblong = $request->fonction['fonction_liblong'];
        $fonction->typefonction_id = $request->fonction['typefonction_id'];
        $fonction->fonction_lache = array_key_exists('fonction_lache', $request->fonction);
        $fonction->fonction_double = array_key_exists('fonction_double', $request->fonction) ;
        $fonction->save();
        return redirect()->route('fonctions.edit', $fonction);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Fonction  $fonction
     * @return \Illuminate\Http\Response
     */
    public function show(Fonction $fonction)
    {
        $typefonctions = TypeFonction::orderBy('typfonction_libcourt')->get();
        return view('fonctions.show', ['fonction'       => $fonction, 
                                        'typefonctions' => $typefonctions] );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Fonction  $fonction
     * @return \Illuminate\Http\Response
     */
    public function edit(Fonction $fonction)
    {
        $typefonctions = TypeFonction::orderBy('typfonction_libcourt')->get();
        return view('fonctions.edit', ['fonction'       => $fonction, 
                                        'typefonctions' => $typefonctions] );
    }
    
    public function choisircompagnonage(Request $request, Fonction $fonction)
    {
        $compagnonages = Compagnonage::orderBy('comp_libcourt')->get();
        $compagnonages = $compagnonages->diff($fonction->compagnonages()->get());
        
        return view('fonctions.choisircompagnonage', [ 'fonction' => $fonction,
                                                       'compagnonages' => $compagnonages]);
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
        $typefonctions = TypeFonction::orderBy('typfonction_libcourt')->get();
        return redirect()->route('fonctions.edit', ['fonction'   => $fonction,
                                                    'typefonctions' => $typefonctions]);
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

    public function choisirstage(Request $request, Fonction $fonction)
    {
        $stages = Stage::orderBy('stage_libcourt')->get();
        $stages = $stages->diff($fonction->stages()->get());
        
        return view('fonctions.choisirstage', [ 'fonction' => $fonction,
                                                'stages' => $stages]);
    }
    
    public function ajouterstage(Request $request, Fonction $fonction)
    {
        $stage_id = intval($request->input('stage_id', 0));
        $query = Stage::where('id', $stage_id)->get();
        if ($query->count() == 1)
        {
            $stage = $query->first();
            $fonction->stages()->attach($stage);
        }
        $typefonctions = TypeFonction::orderBy('typfonction_libcourt')->get();
        return redirect()->route('fonctions.edit', ['fonction'   => $fonction,
                                                    'typefonctions' => $typefonctions]);
    }
    
    public function removestage(Request $request, Fonction $fonction)
    {
        $stage_id = intval($request->input('stage_id', 0));
        $query = Stage::where('id', $stage_id)->get();
        if ($query->count() == 1)
        {
            $stage = $query->first();
            $fonction->stages()->detach($stage);
        }
        $typefonctions = TypeFonction::orderBy('typfonction_libcourt')->get();
        return redirect()->route('fonctions.edit', ['fonction'   => $fonction,
                                                    'typefonctions' => $typefonctions]);    }

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
        $fonction->delete();
        return redirect()->route('fonctions.index');
    }
    
    public function choixmarins(Fonction $fonction)
    {
        $users = User::local()->orderBy('name')->get();
        
        // $usersfonction = $fonction->users()->whereIn('user_id', $users->pluck('id')->all())->get();
        $usersfonction = $fonction->users()->get();
        
        return view('transformation.livretmultiple', ['fonction' => $fonction,
                                                      'users'    => $users,
                                                      'usersfonction' => $usersfonction]);
    }
    
    public function validermarins(Request $request, Fonction $fonction)
    {
        // ddd($request->input());
        $valideur = $request->input('valideur');
        $commentaire = $request->input('commentaire');
        $date_validation = $request->input('date_validation');
        
        if ($request->has('marinsfonc'))
        {
            $marinsid = $request['marinsfonc'];
            foreach ($marinsid as $key => $marinid)
            {
                $marin = User::find(intval($marinid));
                
                if ($request->has('ssobjid'))
                {
                    $sous_objectifs_a_valider = $request['ssobjid'];
                    foreach ($sous_objectifs_a_valider as $key => $value){
                        $sousobjectif = SousObjectif::find($key);
                        $marin->sous_objectifs()->detach($sousobjectif);
                        $marin->sous_objectifs()->attach($sousobjectif, [
                            'valideur'        => $valideur,
                            'commentaire'     => $commentaire,
                            'date_validation' => $date_validation,
                        ]);
                    }
                }
                if ($request->has('tacheid'))
                {
                    $taches_a_valider = $request['tacheid'];
                    foreach ($taches_a_valider as $key => $value){
                        $tache = Tache::find($key);
                        foreach ($tache->coll_sous_objectifs() as $sousobjectif)
                        {
                            $marin->sous_objectifs()->detach($sousobjectif);
                            $marin->sous_objectifs()->attach($sousobjectif, [
                                'valideur'        =>$valideur,
                                'commentaire'     =>$commentaire,
                                'date_validation' => $date_validation,
                            ]);
                        }
                    }
                }
            }
        }
        return redirect()->route('fonctions.choixmarins', ['fonction' => $fonction]);
    }
}
