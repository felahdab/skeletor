<?php
namespace App\Service;

use Illuminate\Support\Carbon;

use App\Models\User;
use App\Models\MindefConnectUser;
use Spatie\Permission\Models\Role;

use App\Service\RandomPasswordGeneratorService;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;

use App\Models\Archive;

class ArchivRestaurService
{
    public static function restauravecdonnees($restauruser, $type)
    {
        if (is_object($restauruser))
            $email = $restauruser->email;
        elseif (is_array($restauruser) && array_key_exists("email", $restauruser))
            $email = $restauruser['email'];

        $user=User::withTrashed()->where ('email', $email)->get()->first();
        $user->date_archivage = null;
        $user->deleted_at = null;
        $user->save();
        
        Mail::to($user->email)
            ->queue(new WelcomeMail($user));
        // Que fait-on avec les stats ? Comment ?            
    }
    public static function restaursansdonnees($restauruser, $type)
    {
        if (is_object($restauruser))
            $email = $restauruser->email;
        elseif (is_array($restauruser) && array_key_exists("email", $restauruser))
            $email = $restauruser['email'];
        
        $user=User::withTrashed()->where ('email', $email)->get()->first();
        $olduserdata=collect($user);
        
        $user->forceDelete();

        $newuserdata = $olduserdata->except([
                                'id', 
                                'date_archivage', 
                                'created_at', 
                                'updated_at', 
                                'deleted_at', 
                                'taux_de_transformation', 
                                'en_transformation', 
                                'socle', 
                                'comete'])->toArray();
        $newuserdata['password'] = RandomPasswordGeneratorService::generateRandomString();

        $newUser=User::create($newuserdata);

        $roleuser = Role::where("name", "user")->get()->first();
        $newUser->roles()->attach($roleuser);

        Mail::to($newUser->email)
            ->queue(new WelcomeMail($newUser));

    }



    public static function archivageuser(User $user)
    {
        $transfoManager = $user->getTransformationManager();
        $date_embarq = new Carbon($user->date_embarq);
        $date_debarq = new Carbon($user->date_debarq);
        $nb_jour_gtr = $date_debarq->diffInDays($date_embarq);

        $userdata=array('grade' => $user->displayGrade(),
                        'specialite' => $user->displaySpecialite(),
                        'brevet' => $user->displayDiplome(),
                        'date_deb' => $user->date_debarq,
                        'date_emb' => $user->date_embarq,
                        'tx_transfo' => $user->taux_de_transformation,  
                        'nb_jour_presence' => $nb_jour_gtr,
                    );

        $etat_parcours=$transfoManager->etat_parcours()->toJson();
        $etat_parcours = json_encode(json_decode($etat_parcours), JSON_PRETTY_PRINT);

        $archive= new Archive;
        $archive->name = $user->name;
        $archive->prenom = $user->prenom;
        $archive->email = $user->email;
        $archive->matricule = $user->matricule;
        $archive->nid = $user->nid;
        $archive->userdata = json_encode($userdata, JSON_PRETTY_PRINT);
        $archive->etat_parcours = $etat_parcours;
        $archive->save();

    }
}