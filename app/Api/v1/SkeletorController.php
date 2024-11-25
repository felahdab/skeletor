<?php

namespace App\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Nwidart\Modules\Facades\Module;
use Illuminate\Database\QueryException;

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

    function status(Request $request) 
    {
        /**
         * Test du fonctionnement de l'API: retourne l'état du service.
         */
        return ["status" => "OK"];
    }

    function status_detailed(Request $request) 
    {
        /**
         * Test du fonctionnement de l'API: retourne l'état du service et les principales variables de configuration.
         */
        $db_connection = config('database.default');

        $db_infos=[
            "DB_ENGINE" => config('database.connections.' . $db_connection . '.driver'),
            "DB_HOST" => config('database.connections.' . $db_connection . '.host'),
        ];
        try {
            $result = DB::statement('SELECT 1');
            $db_infos["CONNECTION_TEST"] = "OK";
        }
        catch (QueryException $e)
        {
            $db_infos["CONNECTION_TEST"] = "NOK";
        }

        $modules_info = [];
        $modules = Module::allEnabled();
        foreach($modules as $module){
            $modules_info[]= [$module->getName() => $module->get('version','')];
        }

        $configuration = [
            "VERSION" => env('APP_VERSION'),
            "DATABASE" =>  $db_infos,
            "MODULES" => $modules_info,
        ];
        return ["status" => "OK",
            "configuration" => $configuration
        ];
    }

}