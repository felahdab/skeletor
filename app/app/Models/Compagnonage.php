<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Tache;
use App\Models\Fonction;

class Compagnonage extends Model
{
    use HasFactory;
	
	public function taches()
	{
		return $this->belongsToMany(Tache::class, 'compagnonage_tache')->withTimestamps();
	}
	
	public function fonctions()
	{
		return $this->belongsToMany(Fonction::class, 'compagnonage_fonction')->withTimestamps();
	}
}
