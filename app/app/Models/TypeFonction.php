<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeFonction extends Model
{
    use HasFactory;
	
	public function fonctions()
	{
		return $this->hasMany(Fonction::class);
	}
}
