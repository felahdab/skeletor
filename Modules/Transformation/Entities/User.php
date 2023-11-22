<?php

namespace Modules\Transformation\Entities;

use Modules\Transformation\Entities\Stage;
use Modules\Transformation\Entities\Fonction;
use Modules\Transformation\Entities\Compagnonage;
use Modules\Transformation\Entities\Tache;
use Modules\Transformation\Entities\Objectif;
use Modules\Transformation\Entities\SousObjectif;

use Modules\Transformation\Services\TransformationManagerService;

use Modules\RH\Entities\Personne;

class User extends Personne
{

    private $fonctionscount = null;

    public function getEnTransformationAttribute()
    {
        if ($this->fonctionscount == null) {
            $fonctions = $this->fonctions;
            $this->fonctionscount = $fonctions->count();
        }

        return $this->fonctionscount > 0;
    }



    public function displayDestination()
    {
        return $this->unite_destination? $this->unite_destination->unite_libcourt : "";
    }
    public function displayDateDebarquement()
    {
        return $this->date_debarq ? $this->date_debarq : "N.C.";
    }

    // Cette partie concerne le suivi de la transformation.
    public $transformation_service = null;
    public function getTransformationManager()
    {
        if ($this->transformation_service == null)
            $this->transformation_service = new TransformationManagerService($this);
        return $this->transformation_service;
    }

    public function fonctions()
    {
        return $this->belongsToMany(Fonction::class, 'transformation_user_fonction', 'user_id')
            ->withTimeStamps()
            ->withPivot(
                'date_lache',
                'valideur_lache',
                'commentaire_lache',
                'date_double',
                'valideur_double',
                'commentaire_double',
                'validation',
                'taux_de_transformation',
                'nb_jours_pour_validation',
                'date_proposition_double',
                'date_proposition_lache'
            );
    }

    public function stages()
    {
        return $this->belongsToMany(Stage::class, 'transformation_user_stage', 'user_id')
            ->withTimeStamps()
            ->withPivot('commentaire', 'date_validation', 'date_validite');
    }

    // Doit renvoyer la liste des sous objectifs que l'utilisateur a valide
    // associes à une fonction actuelle de l'utilisateur.
    public function sous_objectifs_non_orphelins()
    {
        if ($this->colls_sous_objs_non_orphelins != null)
            return $this->colls_sous_objs_non_orphelins;

        $ssobj_du_parcours_de_transformation = $this->coll_sous_objectifs();

        $liste_sous_obj_valides = $this->belongsToMany(SousObjectif::class, 'transformation_user_sous_objectifs')
            ->withTimeStamps()
            ->withPivot('commentaire', 'date_validation', 'valideur', 'date_proposition_validation')
            ->get()
            ->whereNotNull('pivot.date_validation');

        $resultat = $liste_sous_obj_valides->intersect($ssobj_du_parcours_de_transformation);

        $this->colls_sous_objs_non_orphelins = $resultat;
        return $resultat;
    }

    public function sous_objectifs()
    {
        return $this->belongsToMany(SousObjectif::class, 'transformation_user_sous_objectifs', 'user_id')
            ->withTimeStamps()
            ->withPivot('commentaire', 'date_validation', 'valideur', 'nb_jours_pour_validation', 'date_proposition_validation');
    }

    // Cette partie contient des fonctions d'aide pour le suivi de la transformation

    public function aValideLaTache(Tache $tache)
    {
        foreach ($tache->objectifs()->get() as $objectif) {
            if ($this->aValideLObjectif($objectif) == false)
                return false;
        }
        return true;
    }

    public function aValideLObjectif(Objectif $objectif)
    {
        foreach ($objectif->sous_objectifs()->get() as $sous_objectif) {
            if ($this->aValideLeSousObjectif($sous_objectif) == false)
                return false;
        }
        return true;
    }

    public function getEtatDeValidationDesSsojbsAttribute($liste_id_ssobs)
    {
        return $this->sous_objectifs()
            ->whereIn('sous_objectif_id', $liste_id_ssobs)
            ->get()
            ->pluck('pivot.date_validation', 'id')
            ->all();
    }

    public function aValideLeSousObjectif(SousObjectif $sous_objectif)
    {
        $workitem = $this->sous_objectifs()->find($sous_objectif);

        if ($workitem == null)
            return false;
        if ($workitem->pivot->date_validation == null)
            return false;
        return true;
    }

    public function aProposeLeSousObjectif(SousObjectif $sous_objectif)
    {
        $workitem = $this->sous_objectifs()->find($sous_objectif);

        if ($workitem == null)
            return false;
        if ($workitem->pivot->date_validation != null)
            return false;
        if ($workitem->pivot->date_proposition_validation != null)
            return true;
        return false;
    }

    public function aProposeDoubleFonction(Fonction $fonction)
    {
        $userfonction = $this->fonctions->find($fonction);
        if ($userfonction == null)
            return false;

        if ($userfonction->pivot->date_proposition_double != null)
            return true;
        return false;
    }

    public function aValideDoubleFonction(Fonction $fonction)
    {
        $userfonction = $this->fonctions->find($fonction);
        if ($userfonction == null)
            return false;

        if ($userfonction->pivot->date_double != null)
            return true;
        return false;
    }

    public function aProposeLacheFonction(Fonction $fonction)
    {
        $userfonction = $this->fonctions->find($fonction);
        if ($userfonction == null)
            return false;

        if ($userfonction->pivot->date_proposition_lache != null)
            return true;
        return false;
    }

    public function aValideLacheFonction(Fonction $fonction)
    {
        $userfonction = $this->fonctions->find($fonction);
        if ($userfonction == null)
            return false;

        if ($userfonction->pivot->date_lache != null)
            return true;
        return false;
    }

    public function aValideLeStage(Stage $stage)
    {
        $workitem = $this->stages()->find($stage);
        if ($workitem == null)
            return false;
        $workitem = $workitem->pivot;
        if ($workitem->date_validation == null)
            return false;
        return true;
    }

    public function dateValidationDuStage(Stage $stage)
    {
        $workitem = $this->stages()->find($stage);
        if ($workitem == null)
            return "";
        $workitem = $workitem->pivot;
        if ($workitem->date_validation == null)
            return "";
        return $workitem->date_validation;
    }

    public function dateValiditeDuStage(Stage $stage)
    {
        $workitem = $this->stages()->find($stage);
        if ($workitem == null)
            return "";
        $workitem = $workitem->pivot;
        if ($workitem->date_validite == null)
            return "";
        return $workitem->date_validite;
    }

    public function CommentaireDuStage(Stage $stage)
    {
        $workitem = $this->stages()->find($stage);
        return $workitem?->pivot->commentaire;
    }

    /** Renvoie la liste de stages lies a une fonction.
     * Attention: ne verifie pas les doublons !
     */
    public function stagesLiesAUneFonction()
    {
        $collect = collect([]);
        foreach ($this->fonctions()->get() as $fonction)
            foreach ($fonction->stages()->get() as $stage)
                $collect = $collect->concat([$stage]);
        return $collect;
    }

    public function stagesOrphelins()
    {
        // Pour les stages qui ont été attribués à l'utilisateur en dehors du parcours de transformation.
        $orphans = $this->stages()->get()->diff($this->stagesLiesAUneFonction());

        return $orphans;
    }

    public function nbSousObjectifsAValider(Fonction $fonction = null)
    {
        if ($fonction != null) {
            return $fonction->coll_sous_objectifs()->unique()->count();
        } else {
            return $this->coll_sous_objectifs()->unique()->count();
        }
    }

    public function fonctionAQuai()
    {
        $fonction = $this->fonctions()->where('typefonction_id', 2)->get();
        return $fonction;
    }

    public function fonctionAMer()
    {
        $fonction = $this->fonctions()->where('typefonction_id', 1);
        return $fonction;
    }

    public function fonctionsMetier()
    {
        $fonctions = $this->fonctions()->where('typefonction_id', 3);
        return $fonctions;
    }

    public function coll_sous_objectifs(Fonction $fonction = null)
    {
        $key = $fonction == null ? "null" : $fonction->id;
        if (array_key_exists($key, $this->colls_sous_objs)) {
            return $this->colls_sous_objs[$key];
        }

        if ($fonction != null) {
            $this->colls_sous_objs[$fonction->id] = $fonction->coll_sous_objectifs();
            return $this->colls_sous_objs[$fonction->id];
        }

        $coll = collect([]);
        foreach ($this->fonctions()->with('compagnonages.taches.objectifs.sous_objectifs')->get() as $fonction) {
            foreach ($fonction->compagnonages as $compagnonage) {
                foreach ($compagnonage->taches as $tache) {
                    foreach ($tache->objectifs as $objectif) {
                        $coll = $coll->concat($objectif->sous_objectifs);
                    }
                }
            }
        }
        $this->colls_sous_objs["null"] = $coll;
        return $this->colls_sous_objs["null"];
    }

    public function historique_validation_sous_objectifs(Fonction $fonction = null)
    {
        if ($fonction == null) {
            $sous_objectifs_valides = $this->sous_objectifs_non_orphelins()->sortBy('pivot_date_validation');
        } else {
            $sous_objectifs_valides = $this->sous_objectifs_non_orphelins()->sortBy('pivot_date_validation');
            $sous_objectifs_a_garder = $fonction->coll_sous_objectifs();

            $sous_objectifs_valides = $sous_objectifs_valides->intersect($sous_objectifs_a_garder);
        }
        $liste_des_dates_de_validation = $sous_objectifs_valides->pluck('pivot.date_validation');
        $nb_validation_par_date = array_count_values($liste_des_dates_de_validation->all());

        return $nb_validation_par_date;
    }

    public function historique_validation_sous_objectifs_cumulatif(Fonction $fonction = null)
    {
        $nb_validation_par_date = $this->historique_validation_sous_objectifs($fonction);
        $total = 0;
        foreach ($nb_validation_par_date as $key => $value) {
            $total = $total + $value;
            $nb_validation_par_date[$key] = $total;
        }
        return $nb_validation_par_date;
    }

    public function pourcentage_valides_pour_fonction(Fonction $fonction, bool $fullcalc = false)
    {
        if (!$fullcalc) {
            $workitem = $this->fonctions()->find($fonction);
            return $workitem->pivot->taux_de_transformation;
        } else {
            $fcoll = $fonction->coll_sous_objectifs();
            $workcoll = $this->sous_objectifs_non_orphelins()->intersect($fcoll);
            if ($fcoll->sum('ssobj_coeff') == 0) return 0;
            return round(100.0 * $workcoll->sum('ssobj_coeff') / $fcoll->sum('ssobj_coeff'), 2);
        }
    }

    public function taux_de_transformation(bool $fullcalc = false)
    {
        if (!$fullcalc)
            return $this->taux_de_transformation;

        $nb_stage_total = 0;
        $nb_stage_total = $this->stages()->get()->count();

        $nb_stage_valides = 0;
        $nb_stage_valides = $this->stages()->wherePivotNotNull('date_validation')->get()->count();

        $coll_sous_objs_valides = $this->sous_objectifs_non_orphelins();
        $coeff_valides = $coll_sous_objs_valides->sum('ssobj_coeff');
        $coll_sous_objs = $this->coll_sous_objectifs();
        $total_des_coeff = $coll_sous_objs->sum('ssobj_coeff');

        $taux_transfo = 0;
        if ($nb_stage_total > 0 or $total_des_coeff > 0) {
            $taux_transfo = 100 * ($nb_stage_valides + $coeff_valides) / ($nb_stage_total + $total_des_coeff);
        }
        return $taux_transfo;
    }

    public function pourcentage_valides_pour_comp(Compagnonage $comp)
    {
        $compcoll = $comp->coll_sous_objectifs();
        $workcoll = $this->sous_objectifs_non_orphelins()->intersect($compcoll);

        return round(100.0 * $workcoll->sum('ssobj_coeff') / $compcoll->sum('ssobj_coeff'), 2);
    }

    public function NbJoursPresence()
    {
        // renvoie le nb de jours de presence diff date embarquement et aujourd'hui
        $deb = date_create($this->date_embarq);
        $fin = date_create(date('Y-m-d'));
        $nbjours = 0;
        if ($deb < $fin){
            $nbjours = $deb->diff($fin)->format('%a');
        }
        return $nbjours;
    }
    
}
