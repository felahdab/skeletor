<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tache extends Model
{
    use HasFactory;
	
	public function taches()
	{
		return $this->belongsToMany(Tache::class, 'tache_objectif')->withTimestamps();
	}
	
	public function compagnonages()
	{
		return $this->belongsToMany(Compagnonage::class, 'compagnonage_tache')->withTimestamps();
	}
}
