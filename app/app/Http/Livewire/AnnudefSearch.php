<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Http\Controllers\AnnudefController;

use Illuminate\Http\Client\ConnectionException;

class AnnudefSearch extends Component
{
    
    public $tel='';
    public $nom='';
    public $prenom='';
    public $email='';
    public $entite='';
    public $fonction='';
    public $nid='';
    
    public $error='';
    
    public function render()
    {
        try
        {
            $users = collect(AnnudefController::searchUsers($this->tel ,
                                                        $this->nom,
                                                        $this->prenom,
                                                        $this->email,
                                                        '',
                                                        '',
                                                        '' ,
                                                        $this->entite,
                                                        $this->fonction,
                                                        $this->nid
                                                        ));
            $this->error='';
        }
        catch (ConnectionException $e)
        {
            $users =collect([]);
            $this->error='La requête a pris trop de temps et a été abandonnée.';
        }
        return view('livewire.annudef-search',['users' => $users])->withError($this->error);
    }
}
