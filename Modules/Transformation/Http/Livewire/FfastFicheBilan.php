<?php

namespace Modules\Transformation\Http\Livewire;

use Livewire\Component;

use App\Models\User;

class FfastFicheBilan extends Component
{
    public $user=null;
    public $readyToLoad=false;

    public function triggerLoad()
    {
        $this->readyToLoad=true;
    }

    public function mount(User $user)
    {
        $this->user=$user;
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
                                            'liststage' => $liststage]);
    }
}
