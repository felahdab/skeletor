<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

use App\Models\User;

class MemeUnite implements Scope
{
    public function __construct(public ?User $user)
    {
        if ($this->user == null)
        {
            $this->user = auth()->user();
        }
    }

    public function apply(Builder $builder, Model $model): void
    {
        $table = $model->getTable();
        $builder->where($table . '.unite_id', $this->user->unite_id);
    }
}