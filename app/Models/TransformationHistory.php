<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\SousObjectif;
use App\Models\Tache;
use App\Models\Stage;
use App\Models\Fonction;

class TransformationHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'modifying_user_id',
        'event',
        'event_details',
        'modified_user_id',
    ];

    public function modifyinguser()
    {
        return $this->belongsTo(User::class, 'modifying_user_id');
    }

    public function modifieduser()
    {
        return $this->belongsTo(User::class, 'modified_user_id');
    }

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

        // if (in_array($this->event ,["VALIDE_SOUS_OBJECTIF",
                                    // "DEVALIDE_SOUS_OBJECTIF"]))
            // return SousObjectif::find($event_details["sous_objectif"]["id"]);

        // elseif (in_array($this->event , [ "VALIDE_TACHE",
                                            // "DEVALIDE_TACHE"]))
            // return Tache::find($event_details["tache"]["id"]);

        // elseif (in_array($this->event , ["ATTRIBUE_STAGE",
                                         // "RETIRE_STAGE",
                                         // "VALIDE_STAGE",
                                         // "DEVALIDE_STAGE"]))
            // return Stage::find($event_details["stage"]["id"]);

        // elseif (in_array($this->event, ["ATTRIBUE_FONCTION",
                                        // "RETIRE_FONCTION",
                                        // "VALIDE_LACHE_FONCTION",
                                        // "VALIDE_DOUBLE_FONCTION",
                                        // "ANNULE_DOUBLE_FONCTION",
                                        // "ANNULE_LACHE_FONCTION"]))
            // return Fonction::find($event_details["fonction"]["id"]);
    }
}