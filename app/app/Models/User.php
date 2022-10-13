<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\SoftDeletes;

use Lab404\Impersonate\Models\Impersonate;

use App\Jobs\CalculateUserTransformationRatios;

use Illuminate\Database\Eloquent\Model;
use App\Models\TransformationHistory;
use App\Models\Stage;
use App\Models\Fonction;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    use SoftDeletes;
    use Impersonate;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'prenom',
        'email',
        'password',
        // 'matricule',
        'date_embarq',
        'date_debarq',
        'photo',
        'grade_id',
        'specialite_id',
        'diplome_id',
        'secteur_id',
        'unite_id',
        'unite_destination_id',
        'user_comment',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    protected $appends = ['en_transformation'];

    public function scopeLocal($query)
    {
        $currentuser = auth()->user();
        if ($currentuser != null)
        {
            if ($currentuser->hasRole("admin"))
                return;
            $localunit = $currentuser->unite_id;
            if ($localunit != null)
                $query->where('unite_id', $localunit);
        }
    }

    /**
     * Always encrypt password when it is updated.
     *
     * @param $value
     * @return string
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
    
    public function displayString()
    {
        $gradecoll= $this->grade()->get();
        if ($gradecoll->count() == 1)
            $grade = $gradecoll->first()->grade_libcourt;
        else
            $grade = "";
        return $grade . " " . $this->name . " " . $this->prenom;
    }
    
    public function displayServiceSecteur()
    {
        $secteur= $this->secteur()->get();
        if ($secteur->count() == 1)
            $secteur = $secteur->first();
        else
            return "NON RENSEIGNE";
        $service = $secteur->service()->get()->first();
        
        return $service->service_libcourt . "/" . $secteur->secteur_libcourt;
    }
    
    public function displayGrade()
    {
        $grade = $this->grade()->get();
        if ($grade->count() != 0)
        {
            $grade = $grade->first();
            return $grade->grade_libcourt;
        }
        return "";
    }
    
    public function displayDiplome()
    {
        $diplome = $this->diplome()->get();
        if ($diplome->count() != 0)
        {
            $diplome = $diplome->first();
            return $diplome->diplome_libcourt;
        }
        return "";
    }
    
    public function displaySpecialite()
    {
        $specialite = $this->specialite()->get();
        if ($specialite->count() != 0)
        {
            $specialite = $specialite->first();
            return $specialite->specialite_libcourt;
        }
        return "";
    }
    
    public function displaySecteur()
    {
        $secteur = $this->secteur()->get();
        if ($secteur->count() != 0)
        {
            $secteur = $secteur->first();
            return $secteur->secteur_libcourt;
        }
        return "";
    }
    
    public function displayService()
    {
        $secteur= $this->secteur()->get();
        if ($secteur->count() == 1)
            $secteur = $secteur->first();
        else
            return "NON RENSEIGNE";
        $service = $secteur->service()->get()->first()->service_libcourt;
        return $service;
    }
    
    public function displayDestination()
    {
        $unite_destination = $this->unite_destination()->get();
        if ($unite_destination->count() != 0)
        {
            $unite_destination = $unite_destination->first();
            return $unite_destination->unite_libcourt;
        }
        return "";
    }
    public function displayDateDebarquement()
    {
        if ($this->date_debarq == null)
            return "NON RENSEIGNE";
        return $this->date_debarq;
    }
    
    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }
    
    public function specialite()
    {
        return $this->belongsTo(Specialite::class);
    }
    
    public function diplome()
    {
        return $this->belongsTo(Diplome::class);
    }
    
    public function secteur()
    {
        return $this->belongsTo(Secteur::class);
    }
    
    public function service()
    {
        return $this->secteur()->first()->service()->take(1);
    }
    
    public function groupement()
    {
        return $this->secteur()->first()->service()->first()->groupement()->first();
    }
    
    public function unite()
    {
        return $this->belongsTo(Unite::class);
    }
    
    public function unite_destination()
    {
        return $this->belongsTo(Unite::class, 'unite_destination_id');
    }
    // Cette partie concerne le suivi de la transformation.
    public function fonctions()
    {
        return $this->belongsToMany(Fonction::class, 'user_fonction')
            ->withTimeStamps()
            ->withPivot('date_lache','valideur_lache','commentaire_lache',
                    'date_double','valideur_double','commentaire_double',
                    'validation', 'taux_de_transformation');
    }
    
    public function stages()
    {
        return $this->belongsToMany(Stage::class, 'user_stage')
            ->withTimeStamps()
            ->withPivot('commentaire', 'date_validation');
    }
    
    public function sous_objectifs()
    {
        return $this->belongsToMany(SousObjectif::class, 'user_sous_objectif')
            ->withTimeStamps()
            ->withPivot('commentaire', 'date_validation', 'valideur');
    }
    
    // Cette partie contient des fonctions d'aide pour le suivi de la transformation
    public function logTransformationHistory($event, $event_details = "")
    {
        $currentuser = auth()->user();
        
        TransformationHistory::create([
            "modifying_user_id" => $currentuser->id, 
            "modified_user_id" => $this->id, 
            "event" => $event,
            "event_details" => $event_details
        ]);
    }
    
    public function aValideLaFonction(Fonction $fonction)
    {
        foreach ($fonction->$compagnonages->get() as $compagnonage)
        {
            if ($this->aValideLeCompagnonage($compagnonage) == false)
                return $false;
        }
        $userfonction=$user->fonctions()->find($fonction);
        if ($fonction->fonction_double)
        {
            if ($userfonction->pivot->date_double == null)
                return false;
        }
        if ($fonction->fonction_lache)
        {
            if ($userfonction->pivot->date_lache == null)
                return false;
        }
        return true;
    }
    
    public function aValideLeCompagnonage(Compagnonage $compagnonage)
    {
        foreach ($compagnonage->$taches->get() as $tache)
        {
            if ($this->aValideLaTache($tache) == false)
                return $false;
        }
        return true;
    }

    public function aValideLaTache(Tache $tache)
    {
        foreach ($tache->objectifs()->get() as $objectif)
        {
            if ($this->aValideLObjectif($objectif) == false)
                return false;
        }
        return true;
    }
    
    public function aValideLObjectif(Objectif $objectif)
    {
        foreach ($objectif->sous_objectifs()->get() as $sous_objectif)
        {
            if ($this->aValideLeSousObjectif($sous_objectif) == false)
                return false;
        }
        return true;
    }
    
    public function aValideLeSousObjectif(SousObjectif $sous_objectif)
    {
        $workitem = $this->sous_objectifs()->find($sous_objectif);
        if ($workitem == null)
            return false;
        return true;
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
    
    /** Renvoie la liste de stages lies a une fonction.
    * Attention: ne verifie pas les doublons !
    */
    public function stagesLiesAUneFonction()
    {
        $collect = collect([]);
        foreach($this->fonctions()->get() as $fonction)
            foreach($fonction->stages()->get() as $stage)
                $collect = $collect->concat([$stage]);
        return $collect;
    }
    
    public function stagesOrphelins()
    {
        // Pour les stages qui ont été attribués à l'utilisateur en dehors du parcours de transformation.
        $orphans = $this->stages()->get()->diff($this->stagesLiesAUneFonction());
        
        return $orphans;
    }
    
    /**
     * Methode necessaire pour eviter d attacher un stage plusieurs fois.
     *
     * @param $stage
     * @return void
     */
    public function attachStage(Stage $stage)
    {
        if ($this->stages()->get()->contains($stage))
            return;
        $this->stages()->attach($stage);
        CalculateUserTransformationRatios::dispatch($this);
        $this->logTransformationHistory("ATTRIBUE_STAGE", json_encode(["stage" => $stage]));
    }
    
    /**
     * Methode necessaire pour eviter de detacher un stage encore necessaire au
     * titre d'une fonction attribuee a l'utilisateur.
     *
     * @param $stage
     * @return void
     */
    public function detachStage(Stage $stage)
    {
        if (array_key_exists($stage->id,  $this->stagesLiesAUneFonction()->pluck('id','id')->toArray()))
            return;
        $this->stages()->detach($stage);
        CalculateUserTransformationRatios::dispatch($this);
        $this->logTransformationHistory("RETIRE_STAGE", json_encode(["stage" => $stage]));
    }
    
    public function validateStage(Stage $stage, $commentaire, $date_validation)
    {
        $workitem = $this->stages()->find($stage)->pivot;
        if ($workitem != null)
        {
            $workitem->date_validation = $date_validation;
            $workitem->commentaire = $commentaire;
            $workitem->save();
        }
        CalculateUserTransformationRatios::dispatch($this);
        $event_detail = [
            "stage" => $stage->toJson(),
            "commentaire" => $commentaire,
            "date_validation" => $date_validation,
        ];
        $this->logTransformationHistory("VALIDE_STAGE", json_encode($event_detail));
    }
    
    public function unValidateStage(Stage $stage)
    {
        $workitem = $this->stages()->find($stage)->pivot;
        if ($workitem != null)
        {
            $workitem->date_validation = null;
            $workitem->commentaire = null;
            $workitem->save();
        }
        CalculateUserTransformationRatios::dispatch($this);
        $this->logTransformationHistory("DEVALIDE_STAGE", json_encode(["stage" => $stage]));
    }
    
    public function attachFonction(Fonction $fonction)
    {
        $fonctions = $this->fonctions()->get();
        if ( $fonctions->contains($fonction) ){
            return;
        }

        $this->fonctions()->attach($fonction);
        CalculateUserTransformationRatios::dispatch($this);
        $this->logTransformationHistory("ATTRIBUE_FONCTION", json_encode(["fonction" => $fonction]));
        foreach($fonction->stages()->get() as $stage)
            $this->attachStage($stage);
    }
    
    public function detachFonction(Fonction $fonction)
    {
        $this->fonctions()->detach($fonction);
        $this->logTransformationHistory("RETIRE_FONCTION", json_encode(["fonction" => $fonction]));
        foreach($fonction->stages()->get() as $stage)
            $this->detachStage($stage);
        CalculateUserTransformationRatios::dispatch($this);
        
    }
    
    public function nbSousObjectifsAValider(Fonction $fonction=null)
    {
        if ($fonction != null)
        {
            return $fonction->coll_sous_objectifs()->unique()->count();
        }
        else{
            return $this->coll_sous_objectifs()->unique()->count();
        }
    }
    
    public function nbSousObjectifsValides(Objectif $objectif)
    {
        $count=0;
        foreach($objectif->sous_objectifs()->get() as $sous_objectif){
            if ($sous_objectif->users()->find($this) == $this)
                $count = $count + 1;
        }
        return $count;
    }
    
    public function fonctionAQuai()
    {
        $fonction = $this->fonctions()->where('typefonction_id', 2)->get()->first();
        return $fonction;
    }
    
    public function fonctionAMer()
    {
        $fonction = $this->fonctions()->where('typefonction_id', 1)->get()->first();
        return $fonction;
    }
    
    public function fonctionsMetier()
    {
        $fonctions = $this->fonctions()->where('typefonction_id', 3);
        return $fonctions;
    }
    
    public function coll_sous_objectifs(Fonction $fonction=null)
    {
        if ($fonction != null)
        {
            return $fonction->coll_sous_objectifs();
        }
        
        $coll = collect([]);
        foreach ($this->fonctions()->with('compagnonages.taches.objectifs.sous_objectifs')->get() as $fonction)
        {
            foreach ($fonction->compagnonages as $compagnonage)
            {
                foreach ($compagnonage->taches as $tache)
                {
                    foreach ($tache->objectifs as $objectif)
                    {
                        $coll = $coll->concat($objectif->sous_objectifs);
                    }
                }
            }
        }
        return $coll;
    }
    
    public function historique_validation_sous_objectifs(Fonction $fonction=null)
    {
        if ($fonction == null)
        {
            $sous_objectifs_valides = $this->sous_objectifs()->orderBy('pivot_date_validation')->get();
        }
        else
        {
            $sous_objectifs_valides = $this->sous_objectifs()->orderBy('pivot_date_validation')->get();
            $sous_objectifs_a_garder = $fonction->coll_sous_objectifs();
            
            $workcoll = collect([]);
            foreach ($sous_objectifs_a_garder as $sous_obj_a_garder)
            {
                $trouve = $sous_objectifs_valides->find($sous_obj_a_garder);
                if ($trouve != null)
                    $workcoll = $workcoll->concat(collect([$trouve]));
            }
            $sous_objectifs_valides = $workcoll;
        }
        $liste_des_dates_de_validation = $sous_objectifs_valides->pluck('pivot.date_validation');
        $nb_validation_par_date = array_count_values($liste_des_dates_de_validation->all());
        
        return $nb_validation_par_date;
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
    
    public function pourcentage_valides_pour_fonction(Fonction $fonction, bool $fullcalc=false)
    {
        if (! $fullcalc){
            $workitem = $this->fonctions()->find($fonction);
            return $workitem->taux_de_transformation;
        }
        else
        {
        
            // return 100.0 * $this->sous_objectifs()->get()->only($fonction->coll_sous_objectifs())->count() / $fonction->coll_sous_objectifs()->count() ;
            
            // seconde version qui contourne le probleme de array_flip
            $tempcoll = $this->sous_objectifs()->get();
            
            $fcoll= $fonction->coll_sous_objectifs();
            
            $workcoll = collect([]);
            foreach ($fcoll as $sous_obj_a_garder)
            {
                $trouve = $tempcoll->find($sous_obj_a_garder);
                if ($trouve != null)
                    $workcoll = $workcoll->concat(collect([$trouve]));
            }
            if ($fcoll->count()==0)
                return 0;
            return 100.0 * $workcoll->count() / $fcoll->count();
        }
    }
    
    public function taux_de_transformation(bool $fullcalc=false)
    {
        if (! $fullcalc)
            return user->taux_de_transformation;
        
        $nb_stage_total = 0;
        $nb_stage_total = $this->stages()->get()->count();
        
        $nb_stage_valides = 0;
        $nb_stage_valides = $this->stages()->wherePivotNotNull('date_validation')->get()->count();
        
        $sous_objs = $this->coll_sous_objectifs()->unique();
        $total_des_coeff = $sous_objs->sum('ssobj_coeff');
        // $this->info($total_des_coeff);
        
        $sous_objs_valides = $this->sous_objectifs()
                            ->whereNotNull('date_validation')->get();
        $coeff_valides = $sous_objs_valides->sum('ssobj_coeff');
        // $this->info($coeff_valides);
        
        $taux_transfo=0;
        if ($nb_stage_total>0 and $total_des_coeff>0){
            $taux_transfo = 100 * ($nb_stage_valides + $coeff_valides) / ($nb_stage_total + $total_des_coeff) ;
        }
        return $taux_transfo;
    }
    
    public function pourcentage_valides_pour_comp(Compagnonage $comp)
    {
        // return 100.0 * $this->sous_objectifs()->get()->only($comp->coll_sous_objectifs())->count() / $fonction->coll_sous_objectifs()->count() ;
        
        // seconde version qui contourne le probleme de array_flip
        $tempcoll = $this->sous_objectifs()->get();
        
        $workcoll = collect([]);
        foreach ($comp->coll_sous_objectifs() as $sous_obj_a_garder)
        {
            $trouve = $tempcoll->find($sous_obj_a_garder);
            if ($trouve != null)
                $workcoll = $workcoll->concat(collect([$trouve]));
        }
        
        return 100.0 * $workcoll->count() / $comp->coll_sous_objectifs()->count();
    }
    
    public function getFonctionHtmlAttribute(Fonction $fonction)
    {
        
        $taux = $fonction->pivot->taux_de_transformation;
        
        if ($taux == 100)
            $couleur="green";
        elseif($taux >= 70)
            $couleur="gold";
        elseif($taux >= 30)
            $couleur = "orange";
        else
            $couleur = "red";
        
        $stylepart = "color:". $couleur . "'>";
        
        $libelle = $fonction->fonction_libcourt . 
                    "<br>(" . substr($taux,0,4) ."%)" ;
        
        $result = $stylepart . $libelle;
        return $result;
    }
    
    public function getEnTransformationAttribute()
    {
        $fonctions = $this->fonctions()->get();
        return $fonctions->count() > 0;
    }
}