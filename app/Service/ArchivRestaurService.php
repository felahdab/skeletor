<?php
namespace App\Service;

use App\Models\User;
use App\Models\MindefConnectUser;
use Spatie\Permission\Models\Role;

use App\Service\RandomPasswordGeneratorService;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;

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
}