<?php

namespace Modules\Transformation\Entities;

use Modules\RH\Entities\Personne as BasePersonne;

use Modules\Transformation\Scopes\MemeUnite;

class Personne extends BasePersonne
{
    protected $table = 'users';

    protected static function booted(): void
    {
        static::addGlobalScope(new MemeUnite);
    }
}
