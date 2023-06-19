<?php

namespace Modules\Transformation\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Modules\Transformation\Traits\HasTablePrefix;

class TransformationHistory extends Model
{
    use HasFactory;
    use HasTablePrefix;

    protected $fillable = [
        'event',
        'event_details',
        'modifying_user',
        'modified_user',
    ];

    public function target_element()
    {
        $event_details = json_decode($this->event_details, $associative=true);
        if (array_key_exists("sous_objectif", $event_details))
            return SousObjectif::find($event_details["sous_objectif"]["id"]);
        elseif (array_key_exists("tache", $event_details))
            return Tache::find($event_details["tache"]["id"]);
        elseif (array_key_exists("stage", $event_details))
            return Stage::find($event_details["stage"]["id"]);
        elseif (array_key_exists("fonction", $event_details))
            return Fonction::find($event_details["fonction"]["id"]);
    }
}