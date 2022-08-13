<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Compagnonage;
use App\Models\TypeFonction;
use App\Models\Stage;

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
}
