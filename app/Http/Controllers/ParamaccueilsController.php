<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLienRequest;
use App\Http\Requests\UpdateLienRequest;
use Illuminate\Http\Request;
use App\Models\Paramaccueil;
use Illuminate\Support\Facades\Storage;

class ParamaccueilsController extends Controller
{
    public function index()
    {
        $paramaccueil = Paramaccueil::first();
        return view('paramaccueils.index',['paramaccueil' => $paramaccueil]);
    }
    public function update(Request $request)
    {

        $query=Paramaccueil::first();
        if ( $query->count() == 1)
        {
            $paramaccueil = $query->first();
            $paramaccueil->paramaccueil_texte=$request->input('paramaccueil_texte');
            if ($name=$request->file('paramaccueil_image')){
                    // on supprime l'ancienne image
                    $previouspath = storage_path('app/public/images/' . $paramaccueil-> paramaccueil_image);
                    if (file_exists($previouspath))
                        unlink($previouspath);
                    //on stocke la nouvelle image
                    $name->storePublicly("public/images");
                    $paramaccueil->paramaccueil_image=$name->hashName();
            }
            $paramaccueil->save();
        }
        return view('paramaccueils.index',['paramaccueil' => $paramaccueil]);
    }
}
