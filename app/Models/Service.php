<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
	
	public function secteurs()
	{
		return $this->hasMany(Secteur::class);
	}
	
	public function groupement()
	{
		return $this->belongsTo(Groupement::class);
	}
}
