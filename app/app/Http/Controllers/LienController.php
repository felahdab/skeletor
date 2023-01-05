<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLienRequest;
use App\Http\Requests\UpdateLienRequest;
use Illuminate\Http\Request;
use App\Models\Lien;
use Illuminate\Support\Facades\Storage;


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
        $lien=new Lien;
        $lien->lien_lib=$request->input('lien_lib');
        $lien->lien_url=$request->input('lien_url');
        $name=$request->file('lien_image');
        
        if ($name != null){
            $result = $name->storePublicly("public/images");
            $lien->lien_image=$name->hashName();
        }
        else
            $lien->lien_image="";
        
        $lien->save();
        return redirect()->route('liens.index', $lien);
    }

    public function edit(Lien $lien)
    {
        return view('liens.edit', ['lien'   => $lien] );
    }
    
    public function update(UpdateLienRequest $request, Lien $lien)
    {
        $query=Lien::where('id', $lien->id);
        if ( $query->count() == 1)
        {
            //$oldimage=asset('public/images/' . $lien->lien_image);
            $lien = $query->first();
            $lien->lien_lib=$request->input('lien_lib');
            $lien->lien_url=$request->input('lien_url');
            if ($name=$request->file('lien_image')){
                // on supprime l'ancienne image
                $previouspath = storage_path('app/public/images/' . $lien->lien_image);
                if (file_exists($previouspath))
                    unlink($previouspath);
                //on stocke la nouvelle image
                $name->storePublicly("public/images");
                $lien->lien_image=$name->hashName();
            }
            $lien->save();
        }
        return redirect()->route('liens.index', $lien);
    }
    
    public function destroy(Lien $lien) 
    {
        if ($lien->lien_image != ""){
            // on supprime l'ancienne image
            $previouspath = storage_path('app/public/images/' . $lien->lien_image);
                    if (file_exists($previouspath))
                        unlink($previouspath);
        }
        $lien->delete();
        

        return redirect()->route('liens.index')
            ->withSuccess(__('Lien supprimé avec succès.'));
    }
}
