<?php

namespace Modules\Transformation\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

use Modules\Transformation\Scopes\MemeUnite;
use Modules\Transformation\Scopes\MisesPourEmploi;

use App\Models\User;

class MemeUniteOuRenduVisible implements Scope
{
    public function __construct(public ?User $user)
    {
        if ($this->user == null)
        {
            $this->user = auth()->user();
        }
    }
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        $builder->where(function (Builder $builder) {
            new MemeUnite($builder, $this->user);
        })->orWhere(function (Builder $builder) {
            new MisesPourEmploi($builder, $this->user);
        });
    }
}
