<?php

namespace Modules\Transformation\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

use Modules\Transformation\Scopes\MemeUnite;
use Modules\Transformation\Scopes\MisesPourEmploi;

class MemeUniteOuRenduVisible implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        $builder->where(function (Builder $builder) {
            new MemeUnite($builder);
        })->orWhere(function (Builder $builder) {
            new MisesPourEmploi($builder);
        });
    }
}
