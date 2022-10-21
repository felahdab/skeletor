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
    public $user;
    public $readwrite;
    
    public function render()
    {
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
        foreach($selected_compagnonnages as $compid => $value)
        {
            if ($value == true){
                $compagnonage = Compagnonage::find($compid);
                
            }
        }
        
        foreach($selected_taches as $tacheid => $value)
        {
            if ($value == true){
                $tache = Tache::find($tacheid);
                $user->ValidateTache($tache, $date_validation , $commentaire, $valideur);
            }
        }
        
        foreach($selected_objectifs as $objectifid => $value)
        {
            if ($value == true){
                $objectif = Objectif::find($objectifid);
                // ddd($objectif);
            }
        }
        
        foreach($selected_sous_objectifs as $ssobjid => $value)
        {
            if ($value == true){
                $sous_objectif = SousObjectif::find($ssobjid);
                $user->ValidateSousObjectif($sous_objectif, $date_validation , $commentaire, $valideur);
                // ddd($sous_objectif);
            }
        }
    }
    
     public function UnValideElementsDuParcours(User $user, 
                                    $selected_compagnonnages = null,
                                    $selected_taches = null,
                                    $selected_objectifs = null,
                                    $selected_sous_objectifs = null)
    {
        foreach($selected_compagnonnages as $compid => $value)
        {
            if ($value == true){
                $compagnonage = Compagnonage::find($compid);
                
            }
        }
        
        foreach($selected_taches as $tacheid => $value)
        {
            if ($value == true){
                $tache = Tache::find($tacheid);
                $user->UnValidateTache($tache);
            }
        }
        
        foreach($selected_objectifs as $objectifid => $value)
        {
            if ($value == true){
                $objectif = Objectif::find($objectifid);
                // ddd($objectif);
            }
        }
        
        foreach($selected_sous_objectifs as $ssobjid => $value)
        {
            if ($value == true){
                $sous_objectif = SousObjectif::find($ssobjid);
                $user->UnValidateSousObjectif($sous_objectif);
                // ddd($sous_objectif);
            }
        }
    }
}
