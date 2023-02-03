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

class GererTransformationService
{
        /**
     * Methode necessaire pour eviter d attacher un stage plusieurs fois.
     *
     * @param $stage
     * @return void
     */
    public function attachStage(User $user, Stage $stage)
    {
        if ($user->stages()->get()->contains($stage))
            return;
        $user->stages()->attach($stage);
        CalculateUserTransformationRatios::dispatch($user);
        $user->logTransformationHistory("ATTRIBUE_STAGE", json_encode(["stage" => $stage]));
    }
    
    /**
     * Methode necessaire pour eviter de detacher un stage encore necessaire au
     * titre d'une fonction attribuee a l'utilisateur.
     *
     * @param $stage
     * @return void
     */
    public function detachStage(User $user, Stage $stage)
    {
        if (array_key_exists($stage->id,  $user->stagesLiesAUneFonction()->pluck('id','id')->toArray()))
            return;
        $user->stages()->detach($stage);
        CalculateUserTransformationRatios::dispatch($user);
        $user->logTransformationHistory("RETIRE_STAGE", json_encode(["stage" => $stage]));
    }
    
    public function validateStage(User $user, Stage $stage, $commentaire, $date_validation)
    {
        $workitem = $user->stages()->find($stage)->pivot;
        if ($workitem != null)
        {
            $workitem->date_validation = $date_validation;
            $workitem->commentaire = " " . $commentaire;
            $workitem->save();
        }
        CalculateUserTransformationRatios::dispatch($user);
        $event_detail = [
            "stage" => $stage,
            "commentaire" => $commentaire,
            "date_validation" => $date_validation,
        ];
        $user->logTransformationHistory("VALIDE_STAGE", json_encode($event_detail));
    }

    public function validateCommentStage(User $user, Stage $stage, $commentaire)
    {
        $workitem = $user->stages()->find($stage)->pivot;
        if ($workitem != null)
        {
            $workitem->commentaire = $commentaire;
            $workitem->save();
        }
    }
    
    public function unValidateStage(User $user, Stage $stage)
    {
        $workitem = $user->stages()->find($stage)->pivot;
        if ($workitem != null)
        {
            $workitem->date_validation = null;
            $workitem->save();
        }
        CalculateUserTransformationRatios::dispatch($user);
        $user->logTransformationHistory("DEVALIDE_STAGE", json_encode(["stage" => $stage]));
    }
    
    public function attachFonction(User $user, Fonction $fonction)
    {
        $fonctions = $user->fonctions()->get();
        if ( $fonctions->contains($fonction) ){
            return;
        }

        $user->fonctions()->attach($fonction);
        CalculateUserTransformationRatios::dispatch($user);
        $user->logTransformationHistory("ATTRIBUE_FONCTION", json_encode(["fonction" => $fonction]));
        foreach($fonction->stages()->get() as $stage)
            $this->attachStage($user , $stage);
    }
    
    public function detachFonction(User $user, Fonction $fonction)
    {
        $user->fonctions()->detach($fonction);
        $user->logTransformationHistory("RETIRE_FONCTION", json_encode(["fonction" => $fonction]));
        CalculateUserTransformationRatios::dispatch($user);
        
        return;
    }
    
        
    public function ValidateSousObjectif(User $user, SousObjectif $sous_objectif, $date_validation , $commentaire, $valideur)
    {
        $ssobj = $user->sous_objectifs()->find($sous_objectif);
        if ($ssobj != null){
        
        }
        else{
            $user->sous_objectifs()->attach($sous_objectif, [
                'valideur'=> $valideur,
                'commentaire'=> $commentaire,
                'date_validation' => $date_validation,
            ]);
        }
        $event_detail = [
            "sous_objectif" => $sous_objectif,
            "commentaire" => $commentaire,
            "date_validation" => $date_validation,
        ];
        CalculateUserTransformationRatios::dispatch($user);
        $user->logTransformationHistory("VALIDE_SOUS_OBJECTIF", json_encode($event_detail));
    }
    
    public function UnValidateSousObjectif(User $user, SousObjectif $sous_objectif)
    {
        $user->sous_objectifs()->detach($sous_objectif);
        CalculateUserTransformationRatios::dispatch($user);
        $user->logTransformationHistory("DEVALIDE_SOUS_OBJECTIF", json_encode(["sous_objectif" => $sous_objectif]));
    }
    
    public function ValidateObjectif(User $user, Objectif $objectif, $date_validation , $commentaire, $valideur)
    {
        foreach ($objectif->sous_objectifs()->get() as $sous_objectif)
        {
            $this->ValidateSousObjectif($user, $sous_objectif, $date_validation , $commentaire, $valideur);
        }
    }
    
    public function UnValidateObjectif(User $user, Objectif $objectif)
    {
        foreach ($objectif->sous_objectifs()->get() as $sous_objectif)
        {
            $this->UnValidateSousObjectif($user, $sous_objectif);
        }
    }
    
    public function ValidateTache(User $user, Tache $tache, $date_validation , $commentaire, $valideur)
    {
        $event_detail = [
            "tache" => $tache,
            "commentaire" => $commentaire,
            "date_validation" => $date_validation,
            "valideur" => $valideur
        ];
        $user->logTransformationHistory("VALIDE_TACHE", json_encode($event_detail));
        
        foreach ($tache->objectifs()->get() as $objectif)
        {
            $this->ValidateObjectif($user, $objectif, $date_validation , $commentaire, $valideur);
        }
        CalculateUserTransformationRatios::dispatch($user);
    }
    
    public function UnValidateTache(User $user, Tache $tache)
    {
        $event_detail = [
            "tache" => $tache
        ];
        $user->logTransformationHistory("DEVALIDE_TACHE", json_encode($event_detail));
        
        foreach ($tache->objectifs()->get() as $objectif)
        {
            $this->UnValidateObjectif($user, $objectif);
        }
        CalculateUserTransformationRatios::dispatch($user); 
    }
    
    public function ValideLacheFonction(User $user, Fonction $fonction, $date_validation , $commentaire, $valideur)
    {
        $userfonc = $user->fonctions->find($fonction);
        // L'utilisateur a cliqué sur un bouton de validation du lache
        // Si la fonction necessite un double, il faut que le double soit valide avant le lache
        if ($userfonc->pivot->date_double != null or !$fonction->fonction_double) 
        {
            $userfonc->pivot->commentaire_lache=$commentaire;
            $userfonc->pivot->valideur_lache=$valideur;
            $userfonc->pivot->date_lache = $date_validation;
            $userfonc->pivot->save();
            $event_detail = [
                "fonction" => $fonction,
                "commentaire" => $commentaire,
                "date_validation" => $date_validation,
            ];
            $user->logTransformationHistory("VALIDE_LACHE_FONCTION", json_encode($event_detail));
        }
    }
    
    public function UnValideLacheFonction(User $user, Fonction $fonction)
    {
        $userfonc = $user->fonctions->find($fonction);
        if ($userfonc == null)
            return;
        $userfonc->pivot->commentaire_lache=null;
        $userfonc->pivot->valideur_lache=null;
        $userfonc->pivot->date_lache = null;
        $userfonc->pivot->save();
        $user->logTransformationHistory("ANNULE_LACHE_FONCTION", json_encode(["fonction" => $fonction]));
    }
    
    public function UnValideDoubleFonction(User $user, Fonction $fonction)
    {
        $userfonc = $user->fonctions->find($fonction);
        if ($userfonc == null)
            return;
        $userfonc->pivot->commentaire_double=null;
        $userfonc->pivot->valideur_double=null;
        $userfonc->pivot->date_double = null;
        $userfonc->pivot->save();
        $user->logTransformationHistory("ANNULE_DOUBLE_FONCTION", json_encode(["fonction" => $fonction]));
    }
    
    public function ValideDoubleFonction(User $user, Fonction $fonction, $date_validation , $commentaire, $valideur)
    {
        $userfonc = $user->fonctions->find($fonction);
        
        $userfonc->pivot->commentaire_double=$commentaire;
        $userfonc->pivot->valideur_double=$valideur;
        $userfonc->pivot->date_double = $date_validation;
        $userfonc->pivot->save();
        $event_detail = [
            "fonction" => $fonction,
            "commentaire" => $commentaire,
            "date_validation" => $date_validation,
        ];
        $user->logTransformationHistory("VALIDE_DOUBLE_FONCTION", json_encode($event_detail));
    }
    

}