<?php

namespace Modules\Transformation\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Unite;
use Modules\Transformation\Entities\MiseEnVisibilite;
use Modules\Transformation\Entities\User;

class MiseenvisibiliteController extends Controller
{

    public function planning()
    {
        // dd('toto');
        return view('transformation::miseenvisibilite.planning');
    }


    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('transformation::miseenvisibilite.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $unites = Unite::orderBy('unite_libcourt')->get();
        $users = User::orderBy ('name')->orderBy ('prenom')->get();
        return view('transformation::miseenvisibilite.create',[
            'unites' => $unites,
            'users' => $users,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
        foreach ($request->users as $user){
            $mpe=new MiseEnVisibilite();
            $mpe->user_id=$user;
            if ($request->datefin && $request->datedeb)
            {
                $mpe->date_fin=$request->datefin;
                $mpe->date_debut=$request->datedeb;
            }
            else
                $mpe->sans_dates = true;
            $mpe->unite_id=$request->uniteid;     
            $mpe->save();
        }
        
        return redirect()->route('transformation::miseenvisibilite.index');
        
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Miseenvisibilite $miseenvisibilite)
    {
        $unites = Unite::orderBy('unite_libcourt')->get();
        $user= User::where ('id', $miseenvisibilite->user_id)->first();
        return view('transformation::miseenvisibilite.edit', [
                        'miseenvisibilite' => $miseenvisibilite,
                        'user' => $user,
                        'unites' => $unites,
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, Miseenvisibilite $miseenvisibilite)
    {
        $miseenvisibilite->date_debut = null;
        $miseenvisibilite->date_fin = null;
        $miseenvisibilite->sans_dates = true;    
        if ($request->datedeb && $request->datefin){
            $miseenvisibilite->date_debut = $request->datedeb;
            $miseenvisibilite->date_fin = $request->datefin;
            $miseenvisibilite->sans_dates = false;    
        }
        $miseenvisibilite->unite_id = $request->uniteid;
        $miseenvisibilite->save();

        return view('transformation::miseenvisibilite.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Miseenvisibilite $miseenvisibilite)
    {
        $miseenvisibilite->delete();
        return redirect()->route('transformation::miseenvisibilite.index');
    }

}
