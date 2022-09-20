<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Tache;

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
        return view('livewire.tache-list', [
            'taches' => Tache::where('tache_libcourt', 'like', '%'. $this->filter . '%')
                    ->orWhere('tache_liblong', 'like', '%'. $this->filter . '%')
                    ->paginate(10),
            'mode' => $this->mode,
            'compagnonage' => $this->compagnonage
        ]);
    }
}
