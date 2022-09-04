<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Compagnonage;

class CompagnonageList extends Component
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
        return view('livewire.compagnonage-list', [
            'compagnonages' => Compagnonage::where('comp_libcourt', 'like', '%'. $this->filter . '%')
                    ->orWhere('comp_liblong', 'like', '%'. $this->filter . '%')
                    ->paginate(10),
        ]);
    }
}
