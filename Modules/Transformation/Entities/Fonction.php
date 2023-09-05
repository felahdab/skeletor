<?php

namespace Modules\Transformation\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

use Modules\Transformation\Traits\HasTablePrefix;

//use App\Models\User;

class Fonction extends Model
{
    use HasFactory;
    use HasTablePrefix;
    
    public function compagnonages()
    {
        return $this->belongsToMany(Compagnonage::class, 'transformation_compagnonage_fonction')
                ->withTimestamps()
                ->withPivot('ordre');
    }
    
    public function type_fonction()
    {
        return $this->belongsTo(TypeFonction::class, 'typefonction_id');
    }
    
    public function stages()
    {
        return $this->belongsToMany(Stage::class, 'transformation_fonction_stage')->withTimeStamps();
    }
    
    public function users()
    {
        return $this->belongsToMany(Personne::class, 'transformation_user_fonction', null, 'user_id')
        ->withTimeStamps()
        ->withPivot('date_lache','valideur_lache','commentaire_lache',
                    'date_double','valideur_double','commentaire_double',
                    'validation','taux_de_transformation');
    }
    
    public function nbObjectifsAValider()
    {
        $result = Cache::remember($this->cacheKey() . ':nb_objectifs_a_valider', 60*5, function () {
            $count = 0;
            foreach ($this->compagnonages()->get() as $compagnonage)
            {
                foreach ($compagnonage->taches()->get() as $tache)
                {
                    $count = $count + $tache->objectifs()->get()->count();
                }
            }
            return $count;
        });
        return $result;
    }
    
    public function coll_sous_objectifs()
    {
        $result = Cache::remember($this->cacheKey() . ':coll_sous_objectifs', 60*5, function () {
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
        });
        return $result;
    }

    public function cacheKey()
    {
        return sprintf(
            "%s/%s-%s",
            $this->getTable(),
            $this->getKey(),
            $this->updated_at->timestamp
        );
    }
}
