<?php

namespace Modules\Transformation\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

use Modules\Transformation\Scopes\MemeUnite;
use Modules\Transformation\Entities\Personne;
use Modules\Transformation\Scopes\MisesPourEmploi;

class MemeUniteOuRenduVisible implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        $builder->where(function(Builder $builder){
            (new MemeUnite)->apply($builder, Personne::make());
        }) ->orWhere(function(Builder $builder){
            (new MisesPourEmploi)->apply($builder, Personne::make());
        });
    }
}
