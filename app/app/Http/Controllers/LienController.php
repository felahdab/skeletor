<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLienRequest;
use App\Http\Requests\UpdateLienRequest;
use Illuminate\Http\Request;
use App\Models\Lien;

class LienController extends Controller
{
    public function index(Request $request)
    {
        return view('liens.index');
    }

    public function create()
    {
        return view('liens.create');
        //
    }

    public function store(StoreLienRequest $request)
    {
        ddd($_FILES);
        if (move_uploaded_file($_FILES['lien[lien_image]']['tmp_name'],"/assets/images/".$request->lien['lien_image'])){
            $lien=new Lien;
            $lien->lien_lib=$request->lien['lien_lib'];
            $lien->lien_url=$request->lien['lien_url'];
            $lien->lien_image="/assets/images/".$request->lien['lien_image'];
            $lien->unite_id=2;
            $lien->save();
            return redirect()->route('liens.store', $lien);
        }
        else{
            
        }
        
    }

    public function edit(Lien $lien)
    {
        return view('liens.edit', ['lien'   => $lien] );
    }
    
    public function update(UpdateLienRequest $request, Lien $lien)
    {
        $lien_id= intval($request->input('lien')['id']);
        $query=Lien::where('id', $lien_id);
        if ( $query->count() == 1)
        {
            $lien = $query->first();
            $lien->lien_lib=$request->lien['lien_lib'];
            $lien->lien_url=$request->lien['lien_url'];
            $lien->lien_image="/assets/images/".$request->lien['lien_image'];
            $lien->save();
        }
        return redirect()->route('liens.edit', $lien);
    }

}
