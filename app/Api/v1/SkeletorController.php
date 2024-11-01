<?php

namespace App\Api\v1;

use Illuminate\Http\Request;

/**
* @OA\Server(url=L5_SWAGGER_BASE_PATH)
* @OA\Info(title="PolarisOnline API", version= "1.0")
* @OA\Schemes(format="https")
* @OA\SecurityScheme(
*    securityScheme="api token",
*    type="http",
*    scheme="bearer",
* )
* @OA\Get(
*       path= "/api/v1/user",
*       security={{"api token": {}}},
*       @OA\Response(response= 200, description= "Renvoie l'utilisateur pour le compte duquel la requete a ete faite.")
* )
*/
class SkeletorController 
{
    /**
     * Qui suis-je ?
     */
    function who_am_i(Request $request) 
    {
        /**
         * Test du fonctionnement de l'API: retourne l'objet utilisateur.
         */
        return $request->user();
    }

}