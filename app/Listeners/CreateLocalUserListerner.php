<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Events\UnUtilisateurLocalDoitEtreCreeEvent;
use App\Service\RandomPasswordGeneratorService;

use App\Models\User;

class CreateLocalUserListerner
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    // public function handle($event)
    public function handle(UnUtilisateurLocalDoitEtreCreeEvent $event)
    {
        $description = $event->description;

        /**
         * On vérifie ici si l'utilisateur existe déjà pour éviter une exception en cas d'entrée dupliquée.
         */
        $already_existing_user = User::where('email', $description->email)->first();
        if ($already_existing_user)
        {
            return;
        }

        $roles = $event->roles;

        $user = new User;
        
        $user->nom=$description->nom;
        $user->prenom=$description->prenom;
        $user->email=$description->email;

        $user->display_name = $user->prenom . " " . $user->nom;
        $user->password = RandomPasswordGeneratorService::generateRandomString();
        $user->save();
        $user->refresh();

        $user->roles()->sync($roles);

    }
}
