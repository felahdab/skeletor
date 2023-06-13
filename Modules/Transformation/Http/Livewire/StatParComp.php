<?php

namespace App\Http\Livewire;

use Livewire\Component;

use Modules\Transformation\Entities\Compagnonage;

class StatParComp extends Component
{
    public $comp = null;

    public $tabresult = false;

    protected $listeners = ['$refresh'];

    public function selectComp($id)
    {
        $this->comp=Compagnonage::find($id);
        $this->tabresult=true;
    }

    public function render()
    {
        return view('livewire.stat-par-comp');
    }
}
