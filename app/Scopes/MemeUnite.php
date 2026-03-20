<?php

namespace App\Scopes;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class MemeUnite implements Scope
{
    public function __construct(public ?User $user)
    {
        if (null == $this->user) {
            $this->user = auth()->user();
        }
    }

    public function apply(Builder $builder, Model $model): void
    {
        $table = $model->getTable();
        $builder->where($table.'.unite_id', $this->user->unite_id);
    }
}
