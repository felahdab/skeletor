<?php

if (! function_exists('subdirAsset')){
    function subdirAsset($path){
        return asset(env('APP_DIR') . "/" . $path);
    }
}
