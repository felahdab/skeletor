<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Objectif;
use App\Models\Compagnonage;

class Tache extends Model
{
    use HasFactory;
	
	public function objectifs()
	{
		return $this->belongsToMany(Objectif::class, 'tache_objectif')->withTimestamps();
	}
	
	public function compagnonages()
	{
		return $this->belongsToMany(Compagnonage::class, 'compagnonage_tache')->withTimestamps();
	}
}
