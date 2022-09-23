<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Carbon;
use App\Models\User;
use App\Models\Grade;
use App\Models\Diplome;
use App\Models\Fonction;

class InsertUsersFromCSV extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ffast:insertusers
                                {path  : chemin vers le fichier CSV}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert users from CSV file';


    function generateRandomString($length = 10) {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $rows = array_map('str_getcsv', file($this->argument('path')));
        $header = array_shift($rows);
        $csv = array();

        $this->info(json_encode($header));
        foreach($rows as $row)
        {
            $csv[] = array_combine($header, $row);
        }
        
        foreach($csv as $user)
        {
            $email = $user["email"];
            $this->info($email);
            $newUser = User::where('email', $email)->first();
            if ($newUser == null)
            {
                $this->info("Creating new user");
                $newUser = new User;
            }
            $newUser->email = $email;
            $newUser->name    = $user["name"];
            $newUser->prenom  = $user["prenom"];
            $newUser->password = $this->generateRandomString();

            $grade = Grade::where("grade_libcourt", $user["grade"])->first();
            if ($grade != null){
                $newUser->grade_id = $grade->id;
            }
            $diplome = Diplome::where("diplome_libcourt", $user["brevet"])->first();
            if ($diplome != null){
                $newUser->diplome_id = $diplome->id;
            }
            
            
            $pieces = explode("/", $user["date_embarq"]);
            $date_embarq = Carbon::create($pieces[2], $pieces[1],$pieces[0],0,0,0);
            $newUser->date_embarq = $date_embarq;
            
            $newUser->user_comment = $user['specialite'] . " " . $user['lache'];
            
            $newUser->save();
            
            $fonction=Fonction::find($user["fonction_id"]);
            if ($fonction!=null)
            {
                $newUser->attachFonction($fonction);
            }
            
            $situation = $user["Situation"];
            if ($situation == "SOCLE")
            {
                $newUser->syncRoles(["user", "tuteur"]);
            }
            else
                $newUser->syncRoles(["user"]);
            
            
        }
        return 0;
    }
}
