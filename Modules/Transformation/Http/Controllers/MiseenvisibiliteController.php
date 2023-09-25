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
            $mpe->date_fin=$request->datefin;
            $mpe->date_debut=$request->datedeb;
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
        return view('transformation::miseenvisibilite.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('transformation::miseenvisibilite.edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        MiseEnVisibilite::where('id', $id)->delete();
        return redirect()->route('transformation::miseenvisibilite.index');
    }
}
