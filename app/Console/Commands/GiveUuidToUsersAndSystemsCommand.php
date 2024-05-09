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
    protected $description = 'Command description';

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
