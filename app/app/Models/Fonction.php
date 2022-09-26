<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Compagnonage;
use App\Models\TypeFonction;
use App\Models\Stage;
use App\Models\User;

class Fonction extends Model
{
    use HasFactory;
    
    public function compagnonages()
    {
        return $this->belongsToMany(Compagnonage::class, 'compagnonage_fonction')->withTimestamps();
    }
    
    public function type_fonction()
    {
        return $this->belongsTo(TypeFonction::class, 'typefonction_id');
    }
    
    public function stages()
    {
        return $this->belongsToMany(Stage::class, 'fonction_stage')->withTimeStamps();
    }
    
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_fonction')
        ->local()
        ->withTimeStamps()
        ->withPivot('date_lache','valideur_lache','commentaire_lache',
                    'date_double','valideur_double','commentaire_double',
                    'validation');
    }
    
    public function nbObjectifsAValider()
    {
        $count = 0;
        foreach ($this->compagnonages()->get() as $compagnonage)
        {
            foreach ($compagnonage->taches()->get() as $tache)
            {
                $count = $count + $tache->objectifs()->get()->count();
            }
        }
        return $count;
    }
    
    public function coll_sous_objectifs()
    {
        $coll = collect([]);
        foreach ($this->compagnonages()->with('taches.objectifs.sous_objectifs')->get() as $compagnonage)
        {
            foreach ($compagnonage->taches as $tache)
            {
                foreach ($tache->objectifs as $objectif)
                {
                    $coll = $coll->concat($objectif->sous_objectifs);
                }
            }
        }
        return $coll;
    }
}
