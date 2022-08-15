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
        $grade = $this->grade()->get()->first()->grade_libcourt;
        return $grade . " " . $this->name . " " . $this->prenom;
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
    public function aValideLeSousObjectif($sousobjectif)
    {
        $ssobj = $this->sous_objectifs()->find($sousobjectif);
        if ($ssobj == null)
            return false;
        if ($ssobj->pivot->date_validation == null)
            return false;
        return true;
    }
    
    public function aValideLaTache($tache)
    {
        foreach ($tache->objectifs()->get() as $objectif)
        {
            foreach($objectif->sous_objectifs()->get() as $sous_objectif)
            {
                $workitem = $this->sous_objectifs()->find($sous_objectif);
                if ($workitem == null)
                    return false;
                $workitem = $workitem->pivot;
                if ($workitem->date_validation == null)
                    return false;
            }
        }
        return true;
    }
}