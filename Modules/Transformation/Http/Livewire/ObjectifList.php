<?php

namespace Modules\Transformation\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

use Modules\Transformation\Entities\Objectif;

class ObjectifList extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    
    public $filter="";
    public $mode="gestion";
    public $tache=null;
    
    public function updatingFilter()
    {
        $this->resetPage();
    }
    
    public function render()
    { 
        if ($this->mode == "gestion")
        {
            $objectifs=Objectif::where(function (Builder $query) {
                $query->where('objectif_libcourt', 'like', '%'. $this->filter . '%')
                ->orWhere('objectif_liblong', 'like', '%'. $this->filter . '%');
            })
            ->paginate(10);
        }
        elseif ($this->mode == "selection")
        {
            $objectifs=Objectif::whereNotIn('id', $this->tache->objectifs->pluck('id'))
            ->where(function (Builder $query) {
                $query->where('objectif_libcourt', 'like', '%'. $this->filter . '%')
                ->orWhere('objectif_liblong', 'like', '%'. $this->filter . '%');
            })
            ->paginate(10);
        }

        return view('transformation::livewire.objectif-list', [
            'objectifs' => $objectifs,
            'mode' => $this->mode,
            'tache' => $this->tache
        ]);
    }
}
