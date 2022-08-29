<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Secteur extends Model
{
    use HasFactory;
    
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    
    public function users()
    {
        return $this->hasMany(User::class);
    }
    
    public function displayName()
    {
        return $this->secteur_libcourt ;
        //. "-" . $this->service()->service_libcourt ;
    }
}
