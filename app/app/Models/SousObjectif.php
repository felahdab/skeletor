<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SousObjectif extends Model
{
    use HasFactory;
	
	public function livretDisplay()
	{
		return $this->ssobj_lib . " (coeff: " . $this->ssobj_coeff . ")";
	}
	
	public function objectif()
	{
		return $this->belongsTo(Objectif::class);
	}
	
	public function lieu()
	{
		return $this->belongsTo(Lieu::class);
	}
}
