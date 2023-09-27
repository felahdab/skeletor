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
        $tabresult=[];
        if (!is_null($this->planningids) && sizeof($this->planningids)){
            $tabresult['id']='Planning';
            $tabentete=[];
            array_push ($tabresult, $tabentete);
            $mpes=MiseEnVisibilite::whereIn('id', $this->planningids)->orderBy('user_id')->get();
            foreach ($mpes as $mpe){
                array_push ($tabresult, $mpe);
            }

        }
        return view('transformation::livewire.planning', ['tabresult' => $tabresult]);    
    }
}