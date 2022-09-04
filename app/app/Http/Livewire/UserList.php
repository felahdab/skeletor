<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\User;

class UserList extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    
    public $filter="";
    public $mode = "gestion";
    
    public function updatingFilter()
    {
        $this->resetPage();
    }
    
    public function render()
    {
        return view('livewire.user-list', [
            'users' => User::local()->where('name', 'like', '%'. $this->filter . '%')
                                    ->orWhere('prenom', 'like', '%'. $this->filter . '%')
                                    ->paginate(10),
        ]);
    }
}
