<?php
namespace App\Service;

use App\Jobs\CalculateUserTransformationRatios;

use App\Models\TransformationHistory;
use App\Models\Stage;
use App\Models\Fonction;
use App\Models\Objectif;
use App\Models\SousObjectif;
use App\Models\Tache;
use App\Models\UserSousObjectif;
use App\Models\User;

class TransformationManagerService
{
    public $user= null;
    public $parcours = null;
    public $sous_objectifs_valides = null;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->loadParcours();
        $this->loadSousObjectifsValides();
    }

    public function forceReload()
    {
        $this->parcours=null;
        $this->sous_objectifs_valides = null;
    }

    public function loadParcours()
    {
        if ( $this->parcours == null )
            $this->parcours = $this->user->fonctions()->with('compagnonages.taches.objectifs.sous_objectifs')->get();
    }

    public function loadSousObjectifsValides()
    {
        if ( $this->sous_objectifs_valides == null )
            $this->sous_objectifs_valides = $this->user->sous_objectifs->whereNotNull('pivot.date_validation');
    }

    public function sous_objectifs_assignes_dans_le_parcours()
    {
        return $this->parcours;
    }

    public function sous_objectifs_assignes_dans_le_parcours_valides()  
    {

    }
}