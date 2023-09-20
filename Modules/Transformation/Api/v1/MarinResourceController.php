<?php

namespace Modules\Transformation\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Modules\Transformation\Entities\User;
use Modules\Transformation\Http\Resources\UserResource;

class MarinResourceController extends Controller
{
    /**
    * @OA\Get(
    *       path= "/api/v1/marins",
    *       security={{"api token": {}}},
    *        @OA\Response(response= 200, description= "Renvoie la liste des marins en transformation.")
    * )
     */
    public function index()
    {
        return UserResource::collection(User::all()->where('en_transformation', true));
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
    public function show(User $marin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $marin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $marin)
    {
        //
    }
}
