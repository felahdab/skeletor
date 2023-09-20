<?php

namespace Modules\Transformation\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

use Modules\Transformation\Entities\MiseEnVisibilite;

class SansDates implements Scope
{
    /**
     * Ce scope sera applique aux requetes realisees sur les Personne dans le module Transformation
     * Sont objectif est de donner la visibilite sur les Personnes en tenant compte des mises
     * pour emploi renseignees par ailleurs (date de debut / date de fin ou MPE sans limite de temps)
     */
    public function apply(Builder $builder, Model $model): void
    {
        $builder->where('sans_dates', true);
    }

    public function __invoke(Builder $builder)
    {
        $this->apply($builder, MiseEnVisibilite::make());
    }
}
