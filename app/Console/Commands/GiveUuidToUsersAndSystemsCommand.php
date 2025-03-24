<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\User;
use App\Models\Remotesystem;

use Ramsey\Uuid\Uuid;

class GiveUuidToUsersAndSystemsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'skeletor:give-uuid-to-users-and-systems';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'S\'assure que tous les User et tous les Remotesystem ont bien un uuid renseigné.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach(User::whereNull("uuid")->get() as $user){
            $this->info($user->name);
            $uuid = Uuid::uuid4();
            $user->uuid=$uuid;
            $user->save();
        }

        foreach(Remotesystem::whereNull("uuid")->get() as $remotesystem){
            $this->info($remotesystem->name);
            $uuid = Uuid::uuid4();
            $remotesystem->uuid=$uuid;
            $remotesystem->save();
        }


    }
}
