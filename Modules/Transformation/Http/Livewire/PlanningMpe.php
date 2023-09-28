<?php

namespace Modules\Transformation\Http\Livewire;

use App\Http\Livewire\FullCalendar;

use App\Service\RandomColorService;

use Modules\Transformation\Entities\MiseEnVisibilite;
use Modules\Transformation\Entities\User;

class PlanningMpe extends FullCalendar
{
    public $mpes;

    public function mount($mpes)
    {
        $this->mpes = $mpes;
    }

    public function getEvents()
    {
        $events = $this->mpes
            ->transform(function (MiseEnVisibilite $mpe) {
                $mpe->resourceId = $mpe->user_id;
                $mpe->title = $mpe->unite->unite_liblong;
                $mpe->start = $mpe->date_debut;
                $mpe->end = $mpe->date_fin;
                $mpe->color = RandomColorService::randomColor();
                $mpe->url = route('transformation::miseenvisibilite.edit', $mpe);
                return $mpe;
            })
            ->setVisible(['id', 'title', 'resourceId', 'start', 'end', 'color', 'url'])
            ->toArray();
        return $events;
    }

    public function getResources()
    {
        $resources = $this->mpes
            ->map(function (MiseEnVisibilite $item, int $key) {
                return $item->user;
            })
            ->unique()
            ->transform(function (User $user) {
                $user->title = $user->display_name;
                return $user;
            })
            ->setVisible(['id', 'title', 'name', 'display_name'])
            ->toArray();

        return $resources;
    }
}
