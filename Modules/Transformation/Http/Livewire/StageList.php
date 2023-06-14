<?php

namespace Modules\Transformation\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

use Modules\Transformation\Entities\Stage;

class StageList extends Component
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
        return view('transformation::livewire.stage-list', [
            'stages' => Stage::where('stage_libcourt', 'like', '%'. $this->filter . '%')->paginate(10),
            'mode' => $this->mode,
            'fonction' => $this->fonction
        ]);
    }
}
