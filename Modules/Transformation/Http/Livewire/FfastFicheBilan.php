<?php

namespace Modules\Transformation\Http\Livewire;

use Livewire\Component;

class FfastFicheBilan extends Component
{
    public $user=null;
    public $readyToLoad=false;

    public function triggerLoad()
    {
        $this->readyToLoad=true;
    }

    public function mount($user)
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
            
            $nbcomp=count($listcomp);
            $nbstage=count($liststage);
            
            if ($nbcomp == $nbstage)
                ;
            elseif ($nbcomp > $nbstage)
            {
                $complement = array_fill(0, $nbcomp - $nbstage, null);
                $liststage = array_merge($liststage, $complement);
            }
            elseif ($nbcomp < $nbstage)
            {
                $complement = array_fill(0, $nbstage - $nbcomp, null);
                $listcomp = array_merge($listcomp, $complement);
            }
        }

        return view('transformation::livewire.ffast-fiche-bilan', ['user'      => $user,
                                            'listcomp'  => $listcomp,
                                            'liststage' => $liststage]);
    }
}
