<?php

namespace App\Api\v1;

use App\Models\Fonction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class FonctionResourceController extends Controller
{
    /**
     * @OA\Get(
    *       path= "/api/v1/fonctions",
    *       security={{"api token": {}}},
    *        @OA\Response(response= 200, description= "Renvoie la liste des fonctions.")
    * )
     */
    public function index()
    {
        return Fonction::with('compagnonages')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Fonction $fonction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fonction $fonction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fonction $fonction)
    {
        //
    }
}
