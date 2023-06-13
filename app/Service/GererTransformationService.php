<?php

namespace App\Service;

use App\Jobs\CalculateUserTransformationRatios;
use App\Events\UnLivretDeTransformationAChangeEvent;
use App\Dto\ChangementLivretDeTransformationDto;

use Illuminate\Support\Carbon;

use App\Models\TransformationHistory;
use App\Models\Stage;
use Modules\Transformation\Entities\Fonction;
use Modules\Transformation\Entities\Objectif;
use Modules\Transformation\Entities\SousObjectif;
use Modules\Transformation\Entities\Tache;
use Modules\Transformation\Entities\TypeFonction;
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
        $changement = new ChangementLivretDeTransformationDto(auth()->user(), $user, "ATTRIBUE_STAGE", json_encode(["stage" => $stage]));
        UnLivretDeTransformationAChangeEvent::dispatch($changement);
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
        if (array_key_exists($stage->id,  $user->stagesLiesAUneFonction()->pluck('id', 'id')->toArray()))
            return;
        $user->stages()->detach($stage);
        $changement = new ChangementLivretDeTransformationDto(auth()->user(), $user, "RETIRE_STAGE", json_encode(["stage" => $stage]));
        UnLivretDeTransformationAChangeEvent::dispatch($changement);
    }

    public function validateStage(User $user, Stage $stage, $commentaire, $date_validation)
    {
        $workitem = $user->stages()->find($stage)->pivot;
        if ($workitem != null) {
            $nbmois = $stage->duree_validite;
            $date_validite = null;
            if ($nbmois) {
                $date_validite = new Carbon($date_validation);
                $date_validite = $date_validite->addMonth($nbmois);
            }
            $workitem->date_validite = $date_validite;
            $workitem->date_validation = $date_validation;
            $workitem->commentaire = " " . $commentaire;
            $workitem->save();
        }
        $event_detail = [
            "stage" => $stage,
            "commentaire" => $commentaire,
            "date_validation" => $date_validation,
        ];
        $changement = new ChangementLivretDeTransformationDto(auth()->user(), $user, "VALIDE_STAGE", json_encode($event_detail));
        UnLivretDeTransformationAChangeEvent::dispatch($changement);
    }

    public function validateCommentStage(User $user, Stage $stage, $commentaire)
    {
        $workitem = $user->stages()->find($stage)->pivot;
        if ($workitem != null) {
            $workitem->commentaire = $commentaire;
            $workitem->save();
        }
    }

    public function unValidateStage(User $user, Stage $stage)
    {
        $workitem = $user->stages()->find($stage)->pivot;
        if ($workitem != null) {
            $workitem->date_validite = null;
            $workitem->date_validation = null;
            $workitem->save();
        }
        $changement = new ChangementLivretDeTransformationDto(auth()->user(), $user, "DEVALIDE_STAGE", json_encode(["stage" => $stage]));
        UnLivretDeTransformationAChangeEvent::dispatch($changement);
    }

    public function attachFonction(User $user, Fonction $fonction)
    {
        $fonctions = $user->fonctions;
        if ($fonctions->contains($fonction)) {
            return;
        }

        $user->fonctions()->attach($fonction);

        $changement = new ChangementLivretDeTransformationDto(auth()->user(), $user, "ATTRIBUE_FONCTION", json_encode(["fonction" => $fonction]));
        UnLivretDeTransformationAChangeEvent::dispatch($changement);

        foreach ($fonction->stages as $stage)
            $this->attachStage($user, $stage);
    }

    public function detachFonction(User $user, Fonction $fonction)
    {
        $user->fonctions()->detach($fonction);

        $changement = new ChangementLivretDeTransformationDto(auth()->user(), $user, "RETIRE_FONCTION", json_encode(["fonction" => $fonction]));
        UnLivretDeTransformationAChangeEvent::dispatch($changement);

        return;
    }

    public function ValidateSousObjectif(User $user, SousObjectif $sous_objectif, $date_validation, $commentaire, $valideur, $proposition = false)
    {
        $fieldname = $proposition ? 'date_proposition_validation' : 'date_validation';
        $logtype = $proposition ? 'PROPOSE_VALIDATION_SOUS_OBJECTIF' : 'VALIDE_SOUS_OBJECTIF';

        $date_validation = new Carbon($date_validation);
        $date_emb = new Carbon($user->date_embarq);
        $nbjours = $date_emb->diffInDays($date_validation, false);
        if ($nbjours < 0) $nbjours = 0;

        $ssobj = $user->sous_objectifs()->find($sous_objectif);
        if ($ssobj != null) {
            if ($fieldname == 'date_validation' || $ssobj->pivot->date_validation == null) {
                $workitem = $ssobj->pivot;
                $workitem->date_proposition_validation = null;
                $workitem->valideur = $valideur;
                $workitem->$fieldname = $date_validation;
                $workitem->commentaire = $commentaire;
                $workitem->nb_jours_pour_validation = $nbjours;
                $workitem->save();
            }
        } else {
            $user->sous_objectifs()->attach($sous_objectif, [
                'valideur' => $valideur,
                'commentaire' => $commentaire,
                'nb_jours_pour_validation' => $nbjours,
                $fieldname => $date_validation
            ]);
        }
        $event_detail = [
            "sous_objectif" => $sous_objectif,
            "commentaire" => $commentaire,
            $fieldname => $date_validation
        ];

        $changement = new ChangementLivretDeTransformationDto(auth()->user(), $user, $logtype, json_encode($event_detail));
        UnLivretDeTransformationAChangeEvent::dispatch($changement);
    }

    public function UnValidateSousObjectif(User $user, SousObjectif $sous_objectif, $proposition = false)
    {
        $logtype = $proposition ? 'ANNULE_PROPOSITION_DE_VALIDATION_SOUS_OBJECTIF' : 'DEVALIDE_SOUS_OBJECTIF';

        if ($proposition) {
            $ssobj = $user->sous_objectifs->find($sous_objectif);
            if ($ssobj?->pivot->date_validation != null)
                return;
        }

        $user->sous_objectifs()->detach($sous_objectif);

        $changement = new ChangementLivretDeTransformationDto(auth()->user(), $user, $logtype, json_encode(["sous_objectif" => $sous_objectif]));
        UnLivretDeTransformationAChangeEvent::dispatch($changement);
    }

    public function ValidateObjectif(User $user, Objectif $objectif, $date_validation, $commentaire, $valideur, $proposition = false)
    {
        foreach ($objectif->sous_objectifs()->get() as $sous_objectif) {
            $this->ValidateSousObjectif($user, $sous_objectif, $date_validation, $commentaire, $valideur, $proposition);
        }
    }

    public function UnValidateObjectif(User $user, Objectif $objectif, $proposition = false)
    {
        foreach ($objectif->sous_objectifs()->get() as $sous_objectif) {
            $this->UnValidateSousObjectif($user, $sous_objectif, $proposition);
        }
    }

    public function ValidateTache(User $user, Tache $tache, $date_validation, $commentaire, $valideur, $proposition = false)
    {
        $fieldname = $proposition ? 'date_proposition_validation' : 'date_validation';
        $logtype = $proposition ? 'PROPOSE_VALIDATION_TACHE' : 'VALIDE_TACHE';

        $event_detail = [
            "tache" => $tache,
            "commentaire" => $commentaire,
            $fieldname => $date_validation,
            "valideur" => $valideur,
            "proposition" => $proposition
        ];

        $changement = new ChangementLivretDeTransformationDto(auth()->user(), $user, $logtype, json_encode($event_detail));
        UnLivretDeTransformationAChangeEvent::dispatch($changement);

        foreach ($tache->objectifs()->get() as $objectif) {
            $this->ValidateObjectif($user, $objectif, $date_validation, $commentaire, $valideur, $proposition);
        }
    }

    public function UnValidateTache(User $user, Tache $tache, $proposition = false)
    {
        $logtype = $proposition ? 'ANNULE_PROPOSITION_VALIDATION_TACHE' : 'DEVALIDE_TACHE';

        $event_detail = [
            "tache" => $tache
        ];

        $changement = new ChangementLivretDeTransformationDto(auth()->user(), $user, $logtype, json_encode($event_detail));
        UnLivretDeTransformationAChangeEvent::dispatch($changement);

        foreach ($tache->objectifs()->get() as $objectif) {
            $this->UnValidateObjectif($user, $objectif, $proposition);
        }
    }

    public function ValideLacheFonction(User $user, Fonction $fonction, $date_validation, $commentaire, $valideur, $proposition = false)
    {
        $fieldname = $proposition ? 'date_proposition_lache' : 'date_lache';
        $logtype = $proposition ? 'PROPOSITION_VALIDATION_LACHE_FONCTION' : 'VALIDE_LACHE_FONCTION';

        $userfonc = $user->fonctions->find($fonction);
        if ($userfonc == null)
            return;

        if ($proposition && $userfonc->pivot->date_lache == null) {
            // Dans le cas d'une proposition, on ne restreint pas la demande.
            // Il faut juste que le lache n'ait pas deja ete valide
            // Charge à celui qui accepte la proposition de s'assurer qu'elle est bien justifiée.
            $userfonc->pivot->commentaire_lache = $commentaire;
            $userfonc->pivot->valideur_lache = $valideur;
            $userfonc->pivot->date_proposition_lache = $date_validation;
        } elseif (!$proposition && ($userfonc->pivot->date_double != null or !$fonction->fonction_double)) {
            // L'utilisateur a cliqué sur un bouton de validation du lache
            // Si la fonction necessite un double, il faut que le double soit valide avant le lache
            $userfonc->pivot->commentaire_lache = $commentaire;
            $userfonc->pivot->valideur_lache = $valideur;
            $userfonc->pivot->date_lache = $date_validation;
            $userfonc->pivot->date_proposition_lache = null;
            $userfonc->pivot->nb_jours_pour_validation = 0;
            // il manque le calcul du nb de jour avant lacher
            $date_validation = new Carbon($date_validation);
            $date_emb = new Carbon($user->date_embarq);
            $nbjours = $date_emb->diffInDays($date_validation, false);
            if ($nbjours > 0) $userfonc->pivot->nb_jours_pour_validation = $nbjours;
        }
        $userfonc->pivot->save();
        $event_detail = [
            "fonction" => $fonction,
            "commentaire" => $commentaire,
            "proposition" => $proposition,
            $fieldname => $date_validation,
        ];
        $changement = new ChangementLivretDeTransformationDto(auth()->user(), $user, $logtype, json_encode($event_detail));
        UnLivretDeTransformationAChangeEvent::dispatch($changement);
    }

    public function UnValideLacheFonction(User $user, Fonction $fonction, $proposition = false)
    {
        $logtype = $proposition ? 'ANNULE_PROPOSITION_VALIDATION_LACHE_FONCTION' : 'ANNULE_LACHE_FONCTION';


        $userfonc = $user->fonctions->find($fonction);
        if ($userfonc == null)
            return;
        if ($proposition && $userfonc->pivot->date_lache == null) {
            $userfonc->pivot->commentaire_lache = null;
            $userfonc->pivot->valideur_lache = null;
            $userfonc->pivot->date_proposition_lache = null;
        } elseif (!$proposition) {
            $userfonc->pivot->commentaire_lache = null;
            $userfonc->pivot->valideur_lache = null;
            $userfonc->pivot->date_lache = null;
            $userfonc->pivot->date_proposition_lache = null;
            // il faut aussi remettre à 0 le nb de jours
            $userfonc->pivot->nb_jours_pour_validation = 0;
        }
        $userfonc->pivot->save();

        $changement = new ChangementLivretDeTransformationDto(auth()->user(), $user, $logtype, json_encode(["fonction" => $fonction]));
        UnLivretDeTransformationAChangeEvent::dispatch($changement);
    }

    public function UnValideDoubleFonction(User $user, Fonction $fonction, $proposition = false)
    {
        $logtype = $proposition ? 'ANNULE_PROPOSITION_VALIDATION_DOUBLE_FONCTION' : 'ANNULE_DOUBLE_FONCTION';

        $userfonc = $user->fonctions->find($fonction);
        if ($userfonc == null)
            return;
        if ($proposition && $userfonc->pivot->date_double == null) {
            $userfonc->pivot->commentaire_double = null;
            $userfonc->pivot->valideur_double = null;
            $userfonc->pivot->date_proposition_double = null;
        } elseif (!$proposition) {
            $userfonc->pivot->commentaire_double = null;
            $userfonc->pivot->valideur_double = null;
            $userfonc->pivot->date_double = null;
            $userfonc->pivot->date_proposition_double = null;
        }

        $userfonc->pivot->save();

        $changement = new ChangementLivretDeTransformationDto(auth()->user(), $user, $logtype, json_encode(["fonction" => $fonction]));
        UnLivretDeTransformationAChangeEvent::dispatch($changement);
    }

    public function ValideDoubleFonction(User $user, Fonction $fonction, $date_validation, $commentaire, $valideur, $proposition = false)
    {
        $fieldname = $proposition ? 'date_proposition_double' : 'date_double';
        $logtype = $proposition ? 'PROPOSE_VALIDATION_DOUBLE_FONCTION' : 'VALIDE_DOUBLE_FONCTION';

        $userfonc = $user->fonctions->find($fonction);

        $userfonc->pivot->commentaire_double = $commentaire;
        $userfonc->pivot->valideur_double = $valideur;
        if ($proposition && $userfonc->pivot->date_double == null) {
            $userfonc->pivot->date_proposition_double = $date_validation;
        } else {
            $userfonc->pivot->date_double = $date_validation;
            $userfonc->pivot->date_proposition_double = null;
        }
        $userfonc->pivot->save();

        $event_detail = [
            "fonction" => $fonction,
            "commentaire" => $commentaire,
            $fieldname => $date_validation,
            'proposition' => $proposition
        ];

        $changement = new ChangementLivretDeTransformationDto(auth()->user(), $user, $logtype, json_encode($event_detail));
        UnLivretDeTransformationAChangeEvent::dispatch($changement);
    }
}
