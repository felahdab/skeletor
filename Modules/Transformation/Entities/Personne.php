<?php

namespace Modules\Transformation\Entities;

use App\Models\User;

use Modules\Transformation\Scopes\MemeUnite;

class Personne extends User
{
    protected $table = 'users';

    protected static function booted(): void
    {
        static::addGlobalScope(new MemeUnite);
    }
    
}
