<?php

namespace Modules\Transformation\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Modules\Transformation\Traits\HasTablePrefix;

class TypeFonction extends Model
{
    use HasFactory;
	use HasTablePrefix;
	
	public function fonctions()
	{
		return $this->hasMany(Fonction::class);
	}
}
