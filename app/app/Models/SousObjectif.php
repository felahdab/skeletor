<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SousObjectif extends Model
{
    use HasFactory;
	
	public function objectif()
	{
		return $this->belongsTo(Objectif::class);
	}
}
