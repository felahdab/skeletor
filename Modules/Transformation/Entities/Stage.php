<?php

namespace Modules\Transformation\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Carbon;
use Modules\Transformation\Traits\HasTablePrefix;

use App\Models\User;

class Stage extends Model
{
    use HasFactory;
    use HasTablePrefix;
    
    public function type_licence()
    {
        return $this->belongsTo(TypeLicence::class, 'typelicence_id');
    }
    
	public function fonctions()
    {
        return $this->belongsToMany(Fonction::class, 'transformation_fonction_stage')
            ->withTimeStamps();
    }
	
    public function users()
    {
        return $this->belongsToMany(User::class, 'transformation_user_stage')
            ->withTimeStamps()
            ->withPivot('commentaire', 'date_validation', 'date_validite');
    }

    public function miseajourdatevalidite()
    {
        //ttt qui met a jour la date validite pour tous les users qui ont ce stage
        $nbmois = $this->duree_validite;
        $listusers = $this->users()->whereNotNull('date_validation')->get();
        foreach($listusers as $user){
            $workitem = $user->stages()->find($this)->pivot;
            $date_validation = $workitem->date_validation;
            $date_validite = null;
            if ($nbmois){
                $date_validite= new Carbon($date_validation);
                $date_validite = $date_validite->addMonth($nbmois);
            }
            $workitem->date_validite = $date_validite;
            $workitem->save();
        }
    }

}
