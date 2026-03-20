<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class SushiUser extends Model
{
    use Sushi;

    public static $users = [];

    public static function setUsers($users)
    {
        self::$users = $users;
    }

    public function getRows()
    {
        return self::$users;
    }

    protected function sushiShouldCache()
    {
        return false;
    }
}
