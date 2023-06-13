<?php
namespace Modules\Transformation\Services;

use App\Models\TransformationHistory;
use Modules\Transformation\Entities\Stage;
use Modules\Transformation\Entities\Fonction;
use Modules\Transformation\Entities\Compagnonage;
use Modules\Transformation\Entities\Tache;
use Modules\Transformation\Entities\Objectif;
use Modules\Transformation\Entities\SousObjectif;

use Modules\Transformation\Entities\UserSousObjectif;
use App\Models\User;

class TransformationManagerService
{
    public $user= null;
    public $parcours = null;
    public $stages=null;
    public $stages_pluck_id=null;
    public $sous_objectifs = null;
    public $sous_objectifs_valides = null;
    public $sous_objectifs_valides_pluck_id = null;
    public $sous_objectifs_proposes = null;
    public $sous_objectifs_proposes_pluck_id = null;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->loadParcours();
        $this->loadSousObjectifsValides();
        $this->loadSituationDesStages();
    }

    public function forceReload()
    {
        $this->parcours=null;
        $this->sous_objectifs = null;
        $this->sous_objectifs_valides = null;
        $this->sous_objectifs_proposes = null;
        $this->stages = null;
    }

    public function loadParcours()
    {
        if ( $this->parcours == null )
            $this->parcours = $this->user->fonctions()
                ->with('stages')
                ->with('compagnonages.taches.objectifs.sous_objectifs')
                ->get();
    }

    public function loadSousObjectifsValides()
    {
        if ( $this->sous_objectifs == null )
            $this->sous_objectifs = $this->user->sous_objectifs;

        if ( $this->sous_objectifs_valides == null )
        {
            $this->sous_objectifs_valides = $this->sous_objectifs
                    ->whereNotNull('pivot.date_validation')
                    ->flatten();
            $this->sous_objectifs_valides_pluck_id=$this->sous_objectifs_valides->pluck('id');
        }

        if ( $this->sous_objectifs_proposes == null )
        {
            $this->sous_objectifs_proposes = $this->sous_objectifs
                    ->whereNotNull('pivot.date_proposition_validation')
                    ->flatten();
            $this->sous_objectifs_proposes_pluck_id=$this->sous_objectifs_proposes->pluck('id');
        }
    }

    public function loadSituationDesStages()
    {
        if ( $this->stages == null )
        {
            $this->stages = $this->user->stages()->get();
            $this->stages_pluck_id = $this->stages->pluck('id');
        }
    }

    public function fonctionAQuai()
    {
        return $this->parcours->where('typefonction_id', 2);
    }
    
    public function fonctionAMer()
    {
        return $this->parcours->where('typefonction_id', 1);
    }
    
    public function fonctionsMetier()
    {
        return $this->parcours->where('typefonction_id', 3);
    }
    

    public function stages_du_parcours(Fonction $fonction = null)
    {
        $result=collect();
        foreach ($this->parcours as $fct){
            if ( $fonction==null or $fonction->id == $fct->id )
                $result=$result->merge($fct->stages);
        }
        return $result->unique();
    }

    public function compagnonages_du_parcours(Fonction $fonction = null)
    {
        $result=collect();
        foreach ($this->parcours as $fct){
            if ( $fonction==null or $fonction->id == $fct->id )
                $result=$result->merge($fct->compagnonages);
        }
        return $result->unique();
    }

    public function taches_du_parcours(Fonction $fonction = null, Compagnonage $compagnonage = null)
    {
        $result=collect();
        foreach ($this->compagnonages_du_parcours($fonction) as $comp){
            if ( $compagnonage==null or $comp->id == $compagnonage->id )
                $result=$result->merge($comp->taches);
        }
        return $result->unique();
    }

    public function objectifs_du_parcours(Fonction $fonction = null, 
                                            Compagnonage $compagnonage = null,
                                            Tache $tache = null)
    {
        $result=collect();
        foreach ($this->taches_du_parcours($fonction, $compagnonage) as $ta){
            if ( $tache==null or $ta->id == $tache->id )
                $result=$result->merge($ta->objectifs);
        }
        return $result->unique();
    }

    public function sous_objectifs_du_parcours(Fonction $fonction = null, 
                                                Compagnonage $compagnonage = null, 
                                                Tache $tache = null,
                                                Objectif $objectif = null)
    {
        $result=collect();
        foreach ($this->objectifs_du_parcours($fonction, $compagnonage, $tache) as $obj){
            if ( $objectif==null or $obj->id == $objectif->id )
                $result=$result->merge($obj->sous_objectifs);
        }
        return $result->unique();
    }

    public function sous_objectifs_du_parcours_valides(Fonction $fonction = null, 
                                                                    Compagnonage $compagnonage = null,
                                                                    Tache $tache = null,
                                                                    Objectif $objectif = null)  
    {
        return $this->sous_objectifs_valides->whereIn('id', $this->sous_objectifs_du_parcours($fonction, $compagnonage, $tache, $objectif)->pluck('id'));
    }

    public function sous_objectifs_du_parcours_proposes(Fonction $fonction = null, 
                                                                    Compagnonage $compagnonage = null,
                                                                    Tache $tache = null,
                                                                    Objectif $objectif = null)  
    {
        return $this->sous_objectifs_proposes->whereIn('id', $this->sous_objectifs_du_parcours($fonction, $compagnonage, $tache, $objectif)->pluck('id'));
    }

    public function taux_de_transformation_avec_stages(Fonction $fonction = null)
    {
        $total_des_coeff = $this->sous_objectifs_du_parcours($fonction)->reduce(function($carry, $item){
            return $carry + $item->ssobj_coeff;
        });

        $total_des_coeff += $this->stages_du_parcours($fonction)->count();

        if ($total_des_coeff == 0)
            return 0;

        $coeff_valides = $this->sous_objectifs_du_parcours_valides($fonction)
                            ->reduce(function($carry, $item){
                                    return $carry + $item->ssobj_coeff;
                                });

        $coeff_valides += $this->stages_du_parcours($fonction)->whereNotNull('pivot.date_validation')->count();

        return round(100* $coeff_valides / $total_des_coeff, 2);
    }


    public function taux_de_transformation(Fonction $fonction = null, 
                                            Compagnonage $compagnonage = null,
                                            Tache $tache = null,
                                            Objectif $objectif = null)  
    {
        $total_des_coeff = $this->sous_objectifs_du_parcours($fonction, $compagnonage, $tache, $objectif )->reduce(function($carry, $item){
            return $carry + $item->ssobj_coeff;
        });
        if ($total_des_coeff == 0)
            return 0;

        $coeff_valides = $this->sous_objectifs_du_parcours_valides($fonction, $compagnonage, $tache, $objectif)
                            ->reduce(function($carry, $item){
                                    return $carry + $item->ssobj_coeff;
                                });

        return round(100* $coeff_valides / $total_des_coeff, 2);
    }

    public function pourcentage_valides_pour_comp(Compagnonage $comp)
    {
        return $this->taux_de_transformation(null, $comp, null, null);
    }

    public function historique_validation_sous_objectifs(Fonction $fonction=null)
    {
        $firstpoint = [];
        if ($this->user->date_embarq != null)
            $firstpoint = [$this->user->date_embarq => 0];
        
        $otherpoints = array_count_values($this->sous_objectifs_du_parcours_valides($fonction)
                        ->sortBy('pivot_date_validation')
                        ->pluck('pivot.date_validation')
                        ->all()) ; 
        
        ksort($otherpoints, SORT_STRING);

        $result = array_merge( $firstpoint,        
                                $otherpoints);
        return $result;
    }
    
    public function historique_validation_sous_objectifs_cumulatif(Fonction $fonction=null)
    {
        $nb_validation_par_date = $this->historique_validation_sous_objectifs($fonction);
        $total = 0;
        foreach ($nb_validation_par_date as $key => $value)
        {
            $total = $total + $value;
            $nb_validation_par_date[$key] = $total;
        }
        return $nb_validation_par_date;
    }

    public function aValideLeSousObjectif(SousObjectif $ssobj){
        return $this->sous_objectifs_valides_pluck_id->contains($ssobj->id);
    }

    public function dateDeValidationDuSousObjectif(SousObjectif $ssobj){
        if ( ! $this->aValideLeSousObjectif($ssobj))
            return null;
        return $this->sous_objectifs_valides->where('id', $ssobj->id)->first()->pivot->date_validation;
    }

    public function commentaireDeValidationDuSousObjectif(SousObjectif $ssobj){
        if ( ! $this->aValideLeSousObjectif($ssobj))
            return null;
        return $this->sous_objectifs_valides->where('id', $ssobj->id)->first()->pivot->commentaire;
    }

    public function valideurDeValidationDuSousObjectif(SousObjectif $ssobj){
        if ( ! $this->aValideLeSousObjectif($ssobj))
            return null;
        return $this->sous_objectifs_valides->where('id', $ssobj->id)->first()->pivot->valideur;
    }

    public function aProposeLeSousObjectif(SousObjectif $ssobj){
        return $this->sous_objectifs_proposes_pluck_id->contains($ssobj->id);
    }

    public function dateDePropositionDeValidationDuSousObjectif(SousObjectif $ssobj){
        if ( ! $this->aProposeLeSousObjectif($ssobj))
            return null;
        return $this->sous_objectifs_proposes->where('id', $ssobj->id)->first()->pivot->date_validation;
    }

    public function commentaireDePropositionDeValidationDuSousObjectif(SousObjectif $ssobj){
        if ( ! $this->aProposeLeSousObjectif($ssobj))
            return null;
        return $this->sous_objectifs_proposes->where('id', $ssobj->id)->first()->pivot->commentaire;
    }

    public function aValideLObjectif(Objectif $objectif){
        $liste = $this->sous_objectifs_du_parcours(null, null, null, $objectif);
        $valides = $this->sous_objectifs_valides->pluck('id')->intersect($liste->pluck('id'));
        return $liste->count() == $valides->count();
    }

    public function aValideLaTache(Tache $tache){
        $liste = $this->sous_objectifs_du_parcours(null, null, $tache, null);
        $valides = $this->sous_objectifs_valides->pluck('id')->intersect($liste->pluck('id'));
        return $liste->count() == $valides->count();
    }

    public function aValideLeStage(Stage $stage)
    {
        if (! $this->stages_pluck_id->contains($stage->id))
            return false;
        return $this->stages->where('id', $stage->id)->first()->pivot->date_validation != null;
    }

    public function dateDeValidationDuStage(Stage $stage)
    {
        if (! $this->aValideLeStage($stage))
            return null;
        return $this->stages->where('id', $stage->id)->first()->pivot->date_validation ;
    }

    public function stages_orphelins()
    {
        $liste = $this->stages_du_parcours()->pluck('id');
        return $this->stages->whereNotIn('id', $liste);
    }

    public function aProposeDoubleFonction(Fonction $fonction)
    {
        if (! $this->parcours->pluck('id')->contains($fonction->id))
            return false;
        return $this->parcours->where('id', $fonction->id)->first()->pivot->date_proposition_double != null;
    }

    public function aValideDoubleFonction(Fonction $fonction)
    {
        if (! $this->parcours->pluck('id')->contains($fonction->id))
            return false;
        return $this->parcours->where('id', $fonction->id)->first()->pivot->date_double != null;
    }

    public function aProposeLacheFonction(Fonction $fonction)
    {
        if (! $this->parcours->pluck('id')->contains($fonction->id))
            return false;
        return $this->parcours->where('id', $fonction->id)->first()->pivot->date_proposition_lache != null;
    }

    public function aValideLacheFonction(Fonction $fonction)
    {
        if (! $this->parcours->pluck('id')->contains($fonction->id))
            return false;
        return $this->parcours->where('id', $fonction->id)->first()->pivot->date_lache != null;
    }

    public function etat_parcours()
    {
        $parcours_initial=$this->parcours;     

        $parcours_modifie = $parcours_initial->each(function($fonc){
            $fonc->typefonction_lib = $fonc->type_fonction->value('typfonction_libcourt');
            $fonc->tx_transfo_fonc_stage= $this->taux_de_transformation_avec_stages($fonc);
            $fonc->tx_transfo_fonc = $fonc->pivot->taux_de_transformation;
            $fonc->date_lache = $fonc->pivot->date_lache;
            $fonc->date_double = $fonc->pivot->date_double;
            $fonc->nb_jours_pour_validation = $fonc->pivot->nb_jours_pour_validation;
            
            $fonc->compagnonages = $fonc->compagnonages->each(function($comp){
                $comp->tx_transfo_comp= $this->taux_de_transformation(null, $comp, null, null);
                $comp->setHidden(['id','created_at','updated_at', 'pivot']);                
                $comp->taches = $comp->taches->each(function($tach){
                    $tach->tx_transfo_tach = $this->taux_de_transformation(null, null, $tach, null);
                    $tach->setHidden(['id','created_at','updated_at', 'pivot']);
                    $tach->objectifs = $tach->objectifs->each(function($obj){
                        $obj->tx_transfo_obj = $this->taux_de_transformation(null, null, null, $obj);
                        $obj->setHidden(['id','created_at','updated_at','pivot']);
                        $obj->sous_objectifs = $obj->sous_objectifs->each(function($ssobj){
                            $ssobj->date_valid_ssobj = $this->dateDeValidationDuSousObjectif($ssobj);
                            $ssobj->setHidden(['id','created_at','updated_at','ssobj_duree','objectif_id','lieu_id','lieu' ]);
                        });
                    });
                });
            });

            $fonc->stages = $fonc->stages->each(function($stage){
                $stage->date_valid_stage=$this->dateDeValidationDuStage($stage);
                $stage->setHidden(['id','created_at','updated_at','transverse','typelicence_id',
                                    'stage_duree','stage_lieu','stage_capamax','stage_date_fin_licence',
                                    'stage_commentaire','pivot' ]);
            });
            $fonc->setHidden(['id','created_at','updated_at','fonction_lache','fonction_double',
            'typefonction_id','pivot','type_fonction' ]);
        });
        $stages_orphelins = array_values($this->stages_orphelins()->each(function($stageorph){
                $stageorph->date_valid_stage=$stageorph->pivot->date_validation;
                $stageorph->setHidden(['id','created_at','updated_at','transverse','typelicence_id',
                                    'stage_duree','stage_lieu','stage_capamax','stage_date_fin_licence',
                                    'stage_commentaire','pivot' ]);
        })->all());
        $parcours_modifie->put('stages_orphelins', $stages_orphelins);
        return $parcours_modifie;
    }
}