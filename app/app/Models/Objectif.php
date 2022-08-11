<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Objectif extends Model
{
    use HasFactory;
	
	 protected $fillable = [
        'id'
	];
	
	public function sous_objectifs()
	{
		return $this->hasMany(SousObjectif::class);
	}
	
	public function taches()
	{
		return $this->belongsToMany(Tache::class, 'tache_objectif')->withTimestamps();
	}
}
