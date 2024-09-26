<?php

namespace App\Api\v1;

use Illuminate\Http\Request;

/**
 * @tags Skeletor
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