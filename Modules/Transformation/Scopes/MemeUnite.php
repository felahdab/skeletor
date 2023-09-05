<?php

namespace Modules\Transformation\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class MemeUnite implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        if (app()->runningInConsole()) {
            return;
        }
        if (!auth()->check()) {
            return;
        }
        if (auth()->user()->unite_id == null) {
            return;
        }
        if (auth()->user()->can('transformation::view_all_users')) {
            return;
        }
        $builder->where('unite_id', auth()->user()->unite_id);
    }
}
