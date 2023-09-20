<?php

namespace Modules\Transformation\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

use Modules\Transformation\Entities\Personne;

class MemeUnite implements Scope
{
    public function __construct(Builder $builder)
    {
        $this->apply($builder, Personne::make());
    }

    public function apply(Builder $builder, Model $model): void
    {
        $table = $model->getTable();
        $builder->where($table . '.unite_id', auth()->user()->unite_id);
    }
}
