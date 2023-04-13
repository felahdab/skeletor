<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SushiUser extends Model
{
    use \Sushi\Sushi;
    
    public static $users=[];
    public static function setUsers($users)
    {
        self::$users=$users;
    }

    protected function sushiShouldCache(){
        return false;
    }

    public function getRows()
    {
        return self::$users;
    }
    
}