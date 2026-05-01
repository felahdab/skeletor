<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Symfony\Component\Console\Input\InputArgument;
use App\Models\User;
use function Laravel\Prompts\search;

class SkeletorChangeUserPassword extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'skeletor:change-user-password';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Redéfinit le mot de passe local d un utilisateur';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user_email = $this->arguments()['user_email'];

        $new_password = $this->arguments()['newpassword'];
        $new_password2 = $this->arguments()['newpassword2'];

        if ($new_password != $new_password2)
        {
            $this->fail("Les 2 mots de passe ne sont pas identiques !");
        }

        $user = User::where("email", $user_email)->first();
        if (null == $user)
        {
            $this->fail("Aucun utilisateur avec l email {$user_email} n'a été trouvé en base.");
        }

        $user->password = $new_password;
        $user->save();

        $this->info("Mot de passe de l' utilisateur {$user_email} mis à jour.");

    }

    protected function getArguments()
    {
        return [
            ['user_email', InputArgument::REQUIRED, 'L adresse email de l utilisateur dont le mot de passe doit etre redéfini'],
            ['newpassword', InputArgument::REQUIRED, 'Le nouveau mot de passe de connexion'],
            ['newpassword2', InputArgument::REQUIRED, 'Le nouveau mot de passe de connexion une seconde fois'],
        ];
    }

    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'user_email' => fn () => search(
                label: 'Rechercher un utilisateur:',
                placeholder: 'prenom.nom@xxx.com',
                options: fn ($value) => strlen($value) > 0
                    ? User::where('email', 'like', "%{$value}%")->pluck('email')->all()
                    : []
            ),
        ];
    }
}
