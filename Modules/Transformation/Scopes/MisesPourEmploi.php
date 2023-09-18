<?php

namespace Modules\Transformation\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

use App\Models\Unite;
use App\Models\User;
use Modules\Transformation\Entities\MiseEnVisibilite;

class MisesPourEmploi implements Scope
{
    /**
     * Ce scope sera applique aux requetes realisees sur les Personne dans le module Transformation
     * Sont objectif est de donner la visibilite sur les Personnes en tenant compte des mises
     * pour emploi renseignees par ailleurs (date de debut / date de fin ou MPE sans limite de temps)
     */
    public function apply(Builder $builder, Model $model): void
    {
        if (app()->runningInConsole()) {
            return;
        }
        if (!auth()->check()) {
            return;
        }
        $user = auth()->user();

        if ($user->admin) {
            return;
        }
        if ($user->unite_id == null) {
            return;
        }
        if ($user->can('transformation::view_all_users')) {
            return;
        }
        $unite = $user->unite;

        $liste_des_users_visibles = MiseEnVisibilite::query()
            ->where('unite_id', $unite->id)
            ->where(function (Builder $query) {
                $query->where('date_debut', '<=', now())
                    ->where('date_fin', '>=', now());
            })
            ->orWhere(function (Builder $query) {
                $query->where('sans_dates', true);
            })
            ->get()
            ->pluck('user_id');

        $builder->whereIn('id', $liste_des_users_visibles);
    }
}
