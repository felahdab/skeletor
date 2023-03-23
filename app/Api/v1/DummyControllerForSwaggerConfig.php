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
*       path= "/api/v1/user",
*       security={{"api token": {}}},
*       @OA\Response(response= 200, description= "Renvoie l'utilisateur pour le compte duquel la requete a ete faite.")
* )
*/
class DummyControllerForSwaggerConfig 
{

}