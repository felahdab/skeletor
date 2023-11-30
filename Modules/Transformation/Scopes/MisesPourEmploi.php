<?php

namespace Modules\Transformation\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

use Modules\Transformation\Entities\MiseEnVisibilite;

use App\Models\User;
use Modules\Transformation\Entities\Personne;

class MisesPourEmploi implements Scope
{
    public function __construct(Builder $builder, public ?User $user)
    {
        if ($this->user == null) {
            $this->user = auth()->user();
        }
        $this->apply($builder, Personne::make());
    }

    /**
     * Ce scope sera applique aux requetes realisees sur les Personne dans le module Transformation
     * Son objectif est de donner la visibilite sur les Personnes en tenant compte des mises
     * pour emploi renseignees par ailleurs (date de debut / date de fin ou MPE sans limite de temps)
     */
    public function apply(Builder $builder, Model $model): void
    {
        $unite = $this->user->unite;

        if ($unite == null) {
            return;
        }

        $coll_des_mises_en_visibilite_dates = MiseEnVisibilite::query()
            ->whereBelongsTo($unite)
            ->tap(new ActiveNow())
            ->get()
            ->pluck('user_id');

        $coll_des_mises_en_visibilite_permanentes = MiseEnVisibilite::query()
            ->whereBelongsTo($unite)
            ->tap(new SansDates())
            ->get()
            ->pluck('user_id');

        $coll_des_mises_en_visibilite = $coll_des_mises_en_visibilite_dates
            ->concat($coll_des_mises_en_visibilite_permanentes)
            ->unique();

        $table = $model->getTable();
        $key = $model->getKeyName();
        $builder->whereIn($table . '.' . $key, $coll_des_mises_en_visibilite);
    }
}
