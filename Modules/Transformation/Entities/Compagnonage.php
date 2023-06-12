<?php

namespace Modules\Transformation\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

use Modules\Transformation\Traits\HasTablePrefix;

use Modules\Transformation\Entities\Tache;
use Modules\Transformation\Entities\Fonction;

class Compagnonage extends Model
{
    use HasFactory;
    use HasTablePrefix;
    
    public function taches()
    {
        return $this->belongsToMany(Tache::class, 'compagnonage_tache')
            ->withTimestamps()
            ->withPivot('ordre');
    }
    
    public function fonctions()
    {
        return $this->belongsToMany(Fonction::class, 'compagnonage_fonction')->withTimestamps();
    }

    public function getCachedTachesAttribute()
    {
        $result = Cache::remember($this->cacheKey() . ':getCachedTachesAttribute', 60*5, function () {
            return $this->taches()->with('objectifs.sous_objectifs')->get();
        });
        return $result;
    }
    
    public function coll_sous_objectifs()
    {
        $result = Cache::remember($this->cacheKey() . ':coll_sous_objectifs', 60*5, function () {
            $coll = collect([]);
            foreach ($this->taches as $tache)
            {
                $coll = $coll->concat($tache->coll_sous_objectifs());
            }
            return $coll;
        });
        return $result;

        $coll = collect([]);
        foreach ($this->taches as $tache)
        {
            $coll = $coll->concat($tache->coll_sous_objectifs());
        }
        return $coll;
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
