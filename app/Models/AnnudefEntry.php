<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnnudefEntry extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'titre',
        'nom',
        'prenom',
        'gradelong',
        'gradecourt',
        'nid',
        'nomcomplet',
        'nomaffiche',
        'uid',
        'email',
        'unites',
        'status',
        'prenomusuel',
        'categorystatus',
        'categoryrank',
        ];
}
