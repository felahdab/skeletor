<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Fonction;

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
        return view('livewire.fonction-list', [
            'fonctions' => Fonction::where('fonction_libcourt', 'like', '%'. $this->filter . '%')
                    ->orWhere('fonction_liblong', 'like', '%'. $this->filter . '%')
                    ->paginate(10),
        ]);
    }
}
