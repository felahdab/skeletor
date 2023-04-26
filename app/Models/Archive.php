<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Casts\AsCollection;

class Archive extends Model
{
    use HasFactory;

    protected $casts = [
        //'userdata' => 'array',
        //'etat_parcours' => 'array',
    ];

    public function getTauxdetransformationAttribute()
    {
        $a=json_decode($this->userdata);
        return $a->tx_transfo;
    }
    public function getDureeAttribute()
    {
        $a=json_decode($this->userdata);
        return $a->nb_jour_presence;
    }
}
