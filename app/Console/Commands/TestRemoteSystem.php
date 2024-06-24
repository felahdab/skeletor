<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Contracts\Console\PromptsForMissingInput;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;

class TestRemoteSystem extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'skeletor:test-remote-system {url} {token}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test a remote system connectivity';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $url = $this->argument('url');
        $token = $this->argument('token');
        try{
            $response = Http::withToken($token)
                ->withOptions(["verify"=>false])
                ->get($url);
            if ($response->successful() ) {
                $this->info("Connection reussie");
            }
            else {
                $this->warn("Echec: " . $response->body());
            }
        }
        catch (ConnectionException){
            $this->warn("Exception pendant la connexion.");
        }
    }
}
