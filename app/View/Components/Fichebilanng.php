<?php

namespace App\View\Components;

use Illuminate\View\Component;

use App\Models\User;

class Fichebilanng extends Component
{
    public $user=null;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $user=$this->user;
        if ($user == null)
            return;

        $listcomp = [];
        $liststage= [];

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
        return view('components.fichebilan', ['user'      => $user,
                                              'listcomp'  => $listcomp,
                                              'liststage' => $liststage]);
    }
}
