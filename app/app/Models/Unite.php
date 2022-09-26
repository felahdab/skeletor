<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unite extends Model
{
    use HasFactory;
	
	public function users()
	{
		return $this->hasMany(User::class);
	}
	
	public function destination_users()
	{
		return $this->hasMany(User::class, 'unite_destination_id');
	}
}
