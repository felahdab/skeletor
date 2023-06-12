<?php

namespace Modules\Transformation\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Modules\Transformation\Traits\HasTablePrefix;

use App\Models\SousObjectif;
use Modules\Transformation\Entities\Tache;

class Objectif extends Model
{
    use HasFactory;
    use HasTablePrefix;
    
     protected $fillable = [
        'id'
    ];
    
    public function sous_objectifs()
    {
        return $this->hasMany(SousObjectif::class)
                    ->with('lieu');
    }
    
    public function taches()
    {
        return $this->belongsToMany(Tache::class, 'tache_objectif')->withTimestamps();
    }
    
    public function coll_sous_objectifs()
    {
        return $this->sous_objectifs;
    }
}
