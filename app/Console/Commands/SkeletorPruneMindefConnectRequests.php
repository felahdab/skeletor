<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

use App\Models\MindefConnectUser;
use App\Models\User;

#[Signature('skeletor:prune-mindef-connect-requests')]
#[Description('Cette commande compare les demandes MindefConnect en attente avec la liste des utilisateurs et supprime les demandes devenues inutiles.')]
class SkeletorPruneMindefConnectRequests extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        MindefConnectUser::all()->each(function($item){
            $mindef_email = $item->email;
            $local_user = User::where("email", $mindef_email)->first();
            if ($local_user != null)
            {
                /** On a un utilisateur local avec la même adresse email que la demande MindefConnect.
                 * Donc cette demande MindefConnect n'a plus aucun intérêt.
                 * On peut donc la supprimer.
                 */
                $this->warn("La demande pour {$mindef_email} est devenue inutile. On la supprime.");
                $item->delete();
            }
        });
        $this->info("Done.");
    }
}
