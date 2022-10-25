<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Fonction;
use App\Models\Compagnonage;
use App\Models\Tache;
use App\Models\Objectif;
use App\Models\SousObjectif;

use Livewire\Component;

class LivretTransformation extends Component
{
    
    public $mode="unique";
    public $fonctions;
    
    public $user;
    
    public $fonction;
    public $usersfonction;
    
    public $readwrite;
    
    
    public function render()
    {
        if ($this->mode == "unique")
        {
            $this->fonctions = $this->user->fonctions()->orderBy('typefonction_id')->get();
        }
        elseif ($this->mode == "multiple")
        {
            $this->fonctions = [ $this->fonction ];
            $this->usersfonction = $this->fonction->users()->get();
        }
        return view('livewire.livret-transformation');
    }
    
    public function ValideLacheFonction(User $user, Fonction $fonction, $date_validation , $commentaire, $valideur)
    {
        $user->ValideLacheFonction($fonction, $date_validation , $commentaire, $valideur);
    }
    
    public function UnValideLacheFonction(User $user, Fonction $fonction)
    {
        $user->UnValideLacheFonction($fonction);
    }
    
    public function ValideDoubleFonction(User $user, Fonction $fonction, $date_validation , $commentaire, $valideur)
    {
        $user->ValideDoubleFonction($fonction, $date_validation , $commentaire, $valideur);
    }
    
    public function UnValideDoubleFonction(User $user, Fonction $fonction)
    {
        $user->UnValideDoubleFonction($fonction);
    }
    
    public function ValideElementsDuParcours(User $user, 
                                    $date_validation , $commentaire, $valideur,
                                    $selected_compagnonnages = null,
                                    $selected_taches = null,
                                    $selected_objectifs = null,
                                    $selected_sous_objectifs = null)
    {
        foreach($selected_compagnonnages as $compid)
        {
            $compagnonage = Compagnonage::find($compid);
        }
        
        foreach($selected_taches as $tacheid )
        {
            $tache = Tache::find($tacheid);
            $user->ValidateTache($tache, $date_validation , $commentaire, $valideur);
        }
        
        foreach($selected_objectifs as $objectifid)
        {
            $objectif = Objectif::find($objectifid);
            foreach($objectif->sous_objectifs()->get() as $ssobj)
            {
                $user->ValidateSousObjectif($ssobj, $date_validation , $commentaire, $valideur);
            }
        }
        
        foreach($selected_sous_objectifs as $ssobjid)
        {
            $sous_objectif = SousObjectif::find($ssobjid);
            $user->ValidateSousObjectif($sous_objectif, $date_validation , $commentaire, $valideur);
        }
    }
    
     public function ValideElementsDuParcoursMultiple($users = null, 
                                    $date_validation , $commentaire, $valideur,
                                    $selected_compagnonnages = null,
                                    $selected_taches = null,
                                    $selected_objectifs = null,
                                    $selected_sous_objectifs = null)
    {
        foreach ($users as $userid)
        {
            $user = User::find($userid);
            if ($user != null)
            {
                $this->ValideElementsDuParcours($user, 
                                    $date_validation , $commentaire, $valideur,
                                    $selected_compagnonnages ,
                                    $selected_taches ,
                                    $selected_objectifs ,
                                    $selected_sous_objectifs);
            }
        }
    }
    
     public function UnValideElementsDuParcours(User $user, 
                                    $selected_compagnonnages = null,
                                    $selected_taches = null,
                                    $selected_objectifs = null,
                                    $selected_sous_objectifs = null)
    {
        foreach($selected_compagnonnages as $compid)
        {
            $compagnonage = Compagnonage::find($compid);
        }
        
        foreach($selected_taches as $tacheid)
        {
            $tache = Tache::find($tacheid);
            $user->UnValidateTache($tache);
        }
        
        foreach($selected_objectifs as $objectifid)
        {
            $objectif = Objectif::find($objectifid);
            foreach($objectif->sous_objectifs()->get() as $ssobj)
            {
                $user->UnValidateSousObjectif($ssobj);
            }
        }
        
        foreach($selected_sous_objectifs as $ssobjid)
        {
            $sous_objectif = SousObjectif::find($ssobjid);
            $user->UnValidateSousObjectif($sous_objectif);
        }
    }
}
