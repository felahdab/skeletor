<?php

namespace App\Console\Commands;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class ChangeDbPasswordCommand extends Command  implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'skeletor:change-db-password';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cette commande permet de changer le mot de passe d\' un utilisateur dans le serveur de base de données';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $adminUser = $this->argument('username');
        $adminPass = $this->argument('password');
        $newpassword = $this->argument('newpassword');
        $newpassword2 = $this->argument('newpassword2');
        $target_username = $this->argument('target_username');

        
        Config::set('database.connections.temp', [
            'driver' => 'mysql',
            'host' => config('database.connections.mysql.host'),
            'port' => config('database.connections.mysql.port'),
            'database' => null, // not required for ALTER USER
            'username' => $adminUser,
            'password' => $adminPass,
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
        ]);

        if ( $newpassword === $newpassword2 )
        {
            try{
                // Nouveau statement à prendre en compte après une montée de versiond de MariaDB.
                // DB::connection('temp')->statement(
                //     "ALTER USER '{$target_username}'@'%' IDENTIFIED BY ?",
                //     [$newpassword]
                // );
                DB::connection('temp')->statement("SET PASSWORD FOR '{$target_username}'@'%' = PASSWORD('{$newpassword}')");
            }
            catch (\Exception $e){
                $this->warn("Failed!");
                $this->warn($e->getMessage());
            }
            finally {
                DB::purge('temp');
            }
        }
        else {
            $this->fail("Les 2 mots de passe ne correspondent pas.");
        }
    }

    protected function getOptions()
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Remplacer les données déjà présentes en base s\'il y en a.'],
        ];
    }

    protected function getArguments()
    {
        return [
            ['username', InputArgument::REQUIRED, 'Le nom d utilisateur a utiliser pour se connecter à la base'],
            ['password', InputArgument::REQUIRED, 'Le mot de passe de connexion'],
            ['target_username', InputArgument::REQUIRED, 'Le nom de l utilisateur dont on veut changer le mot de passe'],
            ['newpassword', InputArgument::REQUIRED, 'Le nouveau mot de passe de connexion'],
            ['newpassword2', InputArgument::REQUIRED, 'Le nouveau mot de passe de connexion une seconde fois'],
        ];
    }

}
