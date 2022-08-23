<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

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
        'matricule',
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
        $gradecoll= $grade = $this->grade()->get();
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
        return $this->secteur()->service()->groupement();
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
                    'validation');
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
        $workitem = $workitem->pivot;
        if ($workitem->date_validation == null)
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
    
    public function nbSousObjectifsAValider(Fonction $fonction=null)
    {
        if ($fonction != null)
        {
            return $fonction->coll_sous_objectifs()->count();
        }
        else{
            return $this->coll_sous_objectifs()->count();
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
    
    public function coll_sous_objectifs(Fonction $fonction=null)
    {
        if ($fonction != null)
        {
            return $fonction->coll_sous_objectifs();
        }
        
        $coll = collect([]);
        foreach ($this->fonctions()->get() as $fonction)
        {
            $coll = $coll->concat($fonction->coll_sous_objectifs());
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
    
    public function pourcentage_valides_pour_fonction(Fonction $fonction)
    {
        // return 100.0 * $this->sous_objectifs()->get()->only($fonction->coll_sous_objectifs())->count() / $fonction->coll_sous_objectifs()->count() ;
        
        // seconde version qui contourne le probleme de array_flip
        $tempcoll = $this->sous_objectifs()->get();
        
        $workcoll = collect([]);
        foreach ($fonction->coll_sous_objectifs() as $sous_obj_a_garder)
        {
            $trouve = $tempcoll->find($sous_obj_a_garder);
            if ($trouve != null)
                $workcoll = $workcoll->concat(collect([$trouve]));
        }
        
        return 100.0 * $workcoll->count() / $fonction->coll_sous_objectifs()->count();
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
    
}