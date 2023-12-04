<?php

namespace Modules\Transformation\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

use App\Models\User;
use Modules\Transformation\Entities\Personne;

class MemeUnite implements Scope
{
    public function __construct(Builder $builder, public ?User $user)
    {
        if ($this->user == null) {
            $this->user = auth()->user();
        }

        if ($this->user->unite_id == null){
            return;
        }
        $this->apply($builder, Personne::make());
    }

    public function apply(Builder $builder, Model $model): void
    {
        $table = $model->getTable();
        $builder->where($table . '.unite_id', $this->user->unite_id);
    }
}
