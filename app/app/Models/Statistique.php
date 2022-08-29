<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Unite;

class Statistique extends Model
{
    use HasFactory;
    
    protected $table="statistiques";
    
    protected $fillable = [
        'date_stat' ,
        'unite_id' ,
        'name' ,
        'prenom' ,
        'date_debarq' ,
        'nb_jour_gtr' ,
        'grade' ,
        'diplome' ,
        'specialite' ,
        'secteur' ,
        'service' ,
        'gpmt' ,
        'taux_stage_valides' ,
        'taux_comp_valides' ,
        'taux_de_transformation' ,
        'nb_jour_pour_lache_quai' ,
        'nb_jour_pour_lache_mer' ,
        'nb_jour_pour_lache_metier' ,];
    
    public function unite()
    {
        return $this->belongsTo(Unite::class, 'unite_id');
    }
}
