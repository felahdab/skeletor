<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\TypeLicence;
use App\Models\Fonction;

class Stage extends Model
{
    use HasFactory;
    
    public function type_licence()
    {
        return $this->belongsTo(TypeLicence::class, 'typelicence_id');
    }
    
    public function fonctions()
    {
        return $this->belongsToMany(Fonction::class, 'fonction_stage');
    }
}
