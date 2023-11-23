<?php

namespace Modules\Transformation\Http\Livewire;

use Modules\Transformation\Services\GererTransformationService;

use Modules\Transformation\Entities\User;
use Modules\Transformation\Entities\Fonction;
use Modules\Transformation\Entities\Compagnonage;
use Modules\Transformation\Entities\Tache;
use Modules\Transformation\Entities\Objectif;
use Modules\Transformation\Entities\SousObjectif;

use Livewire\Component;

class LivretTransformation extends Component
{

    public $mode = "consultation";
    public $fonctions;

    public $user;

    public $fonction;
    public $usersfonction;

    protected $listeners = ['$refresh'];
    protected $provider = null;

    public function mount()
    {
        switch ($this->mode) {
            case "modification":
            case "validelacherdouble":
            case "modiflivret":
            case "consultation":
            case "proposition":
                $this->provider = $this->user->getTransformationManager();
                $this->fonctions = $this->user->getTransformationManager()->parcours->sortBy('typefonction_id');
                break;
            case "modificationmultiple":
                $this->fonctions = [$this->fonction];
                $this->usersfonction = $this->fonction->users()->orderBy('name')->get();
                break;
        }
    }

    public function render()
    {
        switch ($this->mode) {
            case "modification":
            case "validelacherdouble":
            case "modiflivret":
            case "consultation":
            case "proposition":
                $this->provider = $this->user->getTransformationManager();
                $this->fonctions = $this->user->getTransformationManager()->parcours->sortBy('typefonction_id');
                break;
            case "modificationmultiple":
                $this->fonctions = [$this->fonction];
                $this->usersfonction = $this->fonction->users()->orderBy('name')->get();
                break;
        }
        return view('transformation::livewire.livret-transformation');
    }

    public function ValideLacheFonction(User $user, Fonction $fonction, $date_validation, $commentaire, $valideur)
    {
        $transformationService = new GererTransformationService;
        $transformationService->ValideLacheFonction($user, $fonction, $date_validation, $commentaire, $valideur, $this->mode == "proposition");

        if ($this->mode != "modificationmultiple") {
            $user->getTransformationManager()->forceReload();
            $this->dispatch('$refresh');
        }
    }

    public function UnValideLacheFonction(User $user, Fonction $fonction)
    {
        $transformationService = new GererTransformationService;
        $transformationService->UnValideLacheFonction($user, $fonction, $this->mode == "proposition");
        if ($this->mode != "modificationmultiple") {
            $user->getTransformationManager()->forceReload();
            $this->dispatch('$refresh');
        }
    }

    public function ValideDoubleFonction(User $user, Fonction $fonction, $date_validation, $commentaire, $valideur)
    {
        $transformationService = new GererTransformationService;
        $transformationService->ValideDoubleFonction($user, $fonction, $date_validation, $commentaire, $valideur, $this->mode == "proposition");
        if ($this->mode != "modificationmultiple") {
            $user->getTransformationManager()->forceReload();
            $this->dispatch('$refresh');
        }
    }

    public function UnValideDoubleFonction(User $user, Fonction $fonction)
    {
        $transformationService = new GererTransformationService;
        $transformationService->UnValideDoubleFonction($user, $fonction, $this->mode == "proposition");
        if ($this->mode != "modificationmultiple") {
            $user->getTransformationManager()->forceReload();
            $this->dispatch('$refresh');
        }
    }

    public function ValideElementsDuParcours(
        User $user,
        $date_validation,
        $commentaire,
        $valideur,
        $selected_compagnonnages = null,
        $selected_taches = null,
        $selected_objectifs = null,
        $selected_sous_objectifs = null
    ) {
        foreach ($selected_compagnonnages as $compid) {
            $compagnonage = Compagnonage::find($compid);
        }

        foreach ($selected_taches as $tacheid) {
            $tache = Tache::find($tacheid);
            $transformationService = new GererTransformationService;
            $transformationService->ValidateTache($user, $tache, $date_validation, $commentaire, $valideur, $this->mode == "proposition");
        }

        foreach ($selected_objectifs as $objectifid) {
            $objectif = Objectif::find($objectifid);
            $transformationService = new GererTransformationService;
            foreach ($objectif->sous_objectifs()->get() as $ssobj) {
                $transformationService->ValidateSousObjectif($user, $ssobj, $date_validation, $commentaire, $valideur, $this->mode == "proposition");
            }
        }

        foreach ($selected_sous_objectifs as $ssobjid) {
            $sous_objectif = SousObjectif::find($ssobjid);
            $transformationService = new GererTransformationService;
            $transformationService->ValidateSousObjectif($user, $sous_objectif, $date_validation, $commentaire, $valideur, $this->mode == "proposition");
        }
        if ($this->mode != "modificationmultiple") {
            $user->getTransformationManager()->forceReload();
            $this->dispatch('$refresh');
        }
        $this->dispatch("resetselection");
    }

    public function ValideElementsDuParcoursMultiple(
        $users,
        $date_validation,
        $commentaire,
        $valideur,
        $selected_compagnonnages = null,
        $selected_taches = null,
        $selected_objectifs = null,
        $selected_sous_objectifs = null
    ) {
        foreach ($users as $userid) {
            $user = User::find($userid);
            if ($user != null) {
                $this->ValideElementsDuParcours(
                    $user,
                    $date_validation,
                    $commentaire,
                    $valideur,
                    $selected_compagnonnages,
                    $selected_taches,
                    $selected_objectifs,
                    $selected_sous_objectifs
                );
            }
        }
    }

    public function UnValideElementsDuParcours(
        User $user,
        $selected_compagnonnages = null,
        $selected_taches = null,
        $selected_objectifs = null,
        $selected_sous_objectifs = null
    ) {
        foreach ($selected_compagnonnages as $compid) {
            $compagnonage = Compagnonage::find($compid);
        }

        foreach ($selected_taches as $tacheid) {
            $tache = Tache::find($tacheid);
            $transformationService = new GererTransformationService;
            $transformationService->UnValidateTache($user, $tache, $this->mode == "proposition");
        }

        foreach ($selected_objectifs as $objectifid) {
            $objectif = Objectif::find($objectifid);
            $transformationService = new GererTransformationService;
            foreach ($objectif->sous_objectifs()->get() as $ssobj) {
                $transformationService->UnValidateSousObjectif($user, $ssobj, $this->mode == "proposition");
            }
        }

        foreach ($selected_sous_objectifs as $ssobjid) {
            $sous_objectif = SousObjectif::find($ssobjid);
            $transformationService = new GererTransformationService;
            $transformationService->UnValidateSousObjectif($user, $sous_objectif, $this->mode == "proposition");
        }
        if ($this->mode != "modificationmultiple") {
            $user->getTransformationManager()->forceReload();
            $this->dispatch('$refresh');
        }
        $this->dispatch("resetselection");
    }
}
