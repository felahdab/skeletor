<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Lien;

class LienList extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    
    public $filter="";
    
    public function updatingFilter()
    {
        $this->resetPage();
    }
    
    public function render()
    {
        return view('livewire.liens-list', 
            ['liens' => Lien::where('lien_lib', 'LIKE', '%'. $this->filter .'%')->orderBy('lien_lib')->paginate(10)]);
    }
}
