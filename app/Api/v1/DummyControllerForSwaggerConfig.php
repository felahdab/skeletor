<?php

namespace App\Api\v1;

/**
* @OA\Server(url=L5_SWAGGER_BASE_PATH)
* @OA\Info(title="FFAST API", version= "1.0")
* @OA\Schemes(format="https")
* @OA\SecurityScheme(
*    securityScheme="api token",
*    type="http",
*    scheme="bearer",
* )
* @OA\Get(
*       path="/{tenant}/api/v1/whoami",
*       security={{"api token": {}}},
*       @OA\Parameter(
*           in="path",
*           description="The tenant for which you wish to query",
*           name="tenant",
*           required=true),
*       @OA\Response(response= 200, description= "Renvoie l'utilisateur pour le compte duquel la requete a ete faite.")
* )
*/
class DummyControllerForSwaggerConfig 
{

}