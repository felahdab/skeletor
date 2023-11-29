<?php

namespace Modules\Transformation\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

use Modules\Transformation\Entities\Fonction;

class FonctionList extends Component
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
        return view('transformation::livewire.fonction-list', [
            'fonctions' => Fonction::where('fonction_libcourt', 'like', '%'. $this->filter . '%')
                    ->orWhere('fonction_liblong', 'like', '%'. $this->filter . '%')
                    ->OrderBy('fonction_libcourt')
                    ->paginate(10),
        ]);
    }
}
