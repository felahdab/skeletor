<?php

namespace Modules\Transformation\Http\Livewire;

use Livewire\Component;

use Modules\Transformation\Entities\User;

class FfastFicheBilan extends Component
{
    public $user=null;
    public $mode=null;
    public $readyToLoad=false;

    public function triggerLoad()
    {
        $this->readyToLoad=true;
    }

    public function mount(User $user, $mode)
    {
        $this->user=$user;
        $this->mode=$mode;
    }

    public function render()
    {
        $user=$this->user;
        if ($user == null)
            return;

        $listcomp = [];
        $liststage= [];

        if ($this->readyToLoad)
        {
            foreach($user->fonctions()->get() as $fonction)
            {
                foreach($fonction->compagnonages()->get() as $comp)
                    array_push($listcomp, $comp);
            }
            foreach($user->stages()->get() as $stage)
                array_push($liststage, $stage);
        }

        return view('transformation::livewire.ffast-fiche-bilan', ['user'      => $user,
                                            'listcomp'  => $listcomp,
                                            'liststage' => $liststage,
                                        'mode' => $this->mode]);
    }
}
