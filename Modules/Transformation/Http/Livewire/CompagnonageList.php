<?php

namespace Modules\Transformation\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

use Modules\Transformation\Entities\Compagnonage;

class CompagnonageList extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    
    public $filter="";
    public $mode="gestion";
    public $fonction=null;
    
    public function updatingFilter()
    {
        $this->resetPage();
    }
    
    public function render()
    {
        return view('transformation::livewire.compagnonage-list', [
            'compagnonages' => Compagnonage::where('comp_libcourt', 'like', '%'. $this->filter . '%')
                    ->orWhere('comp_liblong', 'like', '%'. $this->filter . '%')
                    ->paginate(10),
            'mode' => $this->mode,
            'fonction' => $this->fonction
        ]);
    }
}
