<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Objectif;

class ObjectifList extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    
    public $filter="";
    public $mode="gestion";
    
    public function updatingFilter()
    {
        $this->resetPage();
    }
    
    public function render()
    {
        return view('livewire.objectif-list', [
            'objectifs' => Objectif::where('objectif_libcourt', 'like', '%'. $this->filter . '%')
                    ->orWhere('objectif_liblong', 'like', '%'. $this->filter . '%')
                    ->paginate(10),
        ]);
    }
}
