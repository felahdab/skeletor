<?php

namespace Modules\Transformation\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Modules\Transformation\Entities\Objectif;
use Modules\Transformation\Entities\Compagnonage;

use Modules\Transformation\Traits\HasTablePrefix;

class Tache extends Model
{
    use HasFactory;
    use HasTablePrefix;
    
    public function objectifs()
    {
        return $this->belongsToMany(Objectif::class, 'transformation_tache_objectif')
            ->withTimestamps()
            ->withPivot('ordre');
    }
    
    public function compagnonages()
    {
        return $this->belongsToMany(Compagnonage::class, 'transformation_compagnonage_tache')->withTimestamps();
    }
    
    public function nb_ssobj()
    {
        $count=0;
        foreach($this->objectifs as $objectif)
        {
            $count = $count + $objectif->sous_objectifs->count();
        }
        return $count;
    }
    
    public function coll_sous_objectifs()
    {
        $coll = collect([]);
        foreach ($this->objectifs as $objectif)
        {
            $coll = $coll->concat($objectif->coll_sous_objectifs());
        }
        return $coll;
    }
}
