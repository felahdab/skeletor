<?php

namespace Modules\Transformation\Http\Livewire;

use Livewire\Component;

use Modules\Transformation\Entities\MiseEnVisibilite;

class Planning extends Component
{
    public $planningids=null;

    protected $listeners = ['planningUpdated', '$refresh'];

    public function planningUpdated($planningids)
    {
        $this->planningids = $planningids;
        $this->emitSelf('$refresh');
    }

    public function render()
    {
        $mpes=[];
        if (!is_null($this->planningids) && sizeof($this->planningids)){
            $mpes = MiseEnVisibilite::with('user')->whereIn('id', $this->planningids)->orderBy('user_id')->get();
        }
        return view('transformation::livewire.planning', ['mpes' => $mpes]);    
    }
}