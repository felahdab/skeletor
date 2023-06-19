<?php

namespace Modules\Transformation\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

use Modules\Transformation\Entities\Tache;

class TacheList extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    
    public $filter="";
    public $mode="gestion";
    public $compagnonage=null;
    
    public function updatingFilter()
    {
        $this->resetPage();
    }
    
    public function render()
    {
        return view('transformation::livewire.tache-list', [
            'taches' => Tache::where('tache_libcourt', 'like', '%'. $this->filter . '%')
                    ->orWhere('tache_liblong', 'like', '%'. $this->filter . '%')
                    ->paginate(10),
            'mode' => $this->mode,
            'compagnonage' => $this->compagnonage
        ]);
    }
}
