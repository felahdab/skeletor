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
        $name=$request->file('lien_image');
        $result = $name->storePublicly("public/images");
        $lien=new Lien;
        $lien->lien_lib=$request->input('lien_lib');
        $lien->lien_url=$request->input('lien_url');
        $lien->lien_image=$name->hashName();
        $lien->unite_id=2;
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
                try {
                    unlink(storage_path('app/public/images/' . $lien->lien_image));
                    $success = true;
                } catch (ErrorException $e) {
                    $success = false;
                }
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
        // on supprime l'ancienne image
        $success = unlink(storage_path('app/public/images/' . $lien->lien_image));
        
        $lien->delete();

        return redirect()->route('liens.index')
            ->withSuccess(__('Lien supprimé avec succès.'));
    }
}
