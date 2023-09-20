<?php

namespace Modules\Transformation\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Modules\Transformation\Traits\HasTablePrefix;

use App\Models\Lieu;

use Modules\Transformation\Entities\User;

class SousObjectif extends Model
{
    use HasFactory;
	use HasTablePrefix;
	
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
    
    public function users()
    {
        return $this->belongsToMany(User::class, 'transformation_user_sous_objectifs', null, 'user_id')
            ->local()
            ->withTimeStamps()
            ->withPivot('commentaire', 'date_validation', 'valideur');
    }
}
