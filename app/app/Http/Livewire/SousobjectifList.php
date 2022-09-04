<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\SousObjectif;

class SousobjectifList extends Component
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
        return view('livewire.sousobjectif-list', [
            'sousobjectifs' => SousObjectif::where('ssobj_lib', 'like', '%'. $this->filter . '%')
                    ->paginate(10),
        ]);
    }
}
