<?php
namespace App\Service;

class RandomColorService
{

    public static function randomColor()
    {
        $length = 6;
        return "#" . substr(str_shuffle(str_repeat($x='0123456789abcdef', ceil($length/strlen($x)) )), 1 ,$length);
    }
}