<?php
namespace App\Service;



use App\Models\User;
use App\Models\MindefConnectUser;

class ArchivRestaurService
{
    public static function restauravecdonnees($restauruser, $type)
    {
        if ($type == 'annudef'){
            $email= $restauruser['email'];
        }
        else{
            $email=$restauruser->email;
        }
        $user=User::withTrashed()->where ('email', $email)->get()->first();
        $user->date_archivage = null;
        $user->deleted_at = null;
        $user->save();
        if ($type=='mindefconnect'){
            MindefConnectUser::find($restauruser->id)->delete();
        }
        
        // Que fait-on avec les stats ? Comment ?            
    }
    public static function restaursansdonnees($restauruser, $type)
    {
        if ($type == 'annudef'){
            $email= $restauruser['email'];
        }
        else{
            $email=$restauruser->email;
        }
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
        $newuserdata['password'] = $this->generateRandomString();

        $newUser=User::create($newuserdata);

        $roleuser = Role::where("name", "user")->get()->first();
        $newUser->roles()->attach($roleuser);

        if ($type=='mindefconnect'){
            MindefConnectUser::find($restauruser->id)->delete();
        }
    }
}