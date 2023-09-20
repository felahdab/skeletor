<?php

namespace Modules\Transformation\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

use Modules\Transformation\Entities\MiseEnVisibilite;

use Modules\Transformation\Entities\Personne;

class MisesPourEmploi implements Scope
{
    public function __construct(Builder $builder)
    {
        $this->apply($builder, Personne::make());
    }

    /**
     * Ce scope sera applique aux requetes realisees sur les Personne dans le module Transformation
     * Son objectif est de donner la visibilite sur les Personnes en tenant compte des mises
     * pour emploi renseignees par ailleurs (date de debut / date de fin ou MPE sans limite de temps)
     */
    public function apply(Builder $builder, Model $model): void
    {
        $user = auth()->user();
        $unite = $user->unite;

        $liste_des_users_visibles = MiseEnVisibilite::query()
            ->whereBelongsTo($unite)
            ->tap(new ActiveNow())
            ->get()
            ->pluck('user_id');

        $liste_des_users_visibles = $liste_des_users_visibles
            ->concat(MiseEnVisibilite::query()
                ->whereBelongsTo($unite)
                ->tap(new SansDates())
                ->get()
                ->pluck('user_id'))
            ->unique();

        $table = $model->getTable();
        $key = $model->getKeyName();
        $builder->whereIn($table . '.' . $key, $liste_des_users_visibles);
    }
}
