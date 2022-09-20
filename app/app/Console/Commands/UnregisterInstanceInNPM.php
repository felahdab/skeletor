<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UnregisterInstanceInNPM extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ffast:unregisterinstance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Removes the custom location for the instance';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $NGINXSERVER   = env("NGINXSERVER");
        $NGINXPORT   = env("NGINXPORT");
        $NGINXIDENTITY = env("NGINXIDENTITY");
        $NGINXSECRET = env("NGINXSECRET");
        
        $BASEURL = 'http://' . $NGINXSERVER . ':' . $NGINXPORT . '/api/';
        $response = Http::get($BASEURL);
        // $this->info($response->body());
        
        $response = Http::post($BASEURL . 'tokens', [
            'identity'=> $NGINXIDENTITY,
            'secret' => $NGINXSECRET
            ]);
        $token = $response['token'];
        
        $response = Http::withToken($token)->get($BASEURL . 'nginx/proxy-hosts/');
        // $this->info($response->body());
        $proxyid = null;
        foreach ($response->json() as $proxyhost)
        {
            $id = $proxyhost["id"];
            $domains = $proxyhost["domain_names"];
            if (in_array($this->argument('domain'), $domains)){
                $proxyid = $id;
            }
        }
        if (is_null($proxyid))
        {
            $this->error("Could not find Proxy Host entry for domain " . $this->argument('domain'));
            return 1;
        }
        
        $response = Http::withToken($token)->get($BASEURL . 'nginx/proxy-hosts/' . $proxyid);
        // $this->info($response->body());
        
        $currentlocations = $response['locations'];
        
        // $this->info(json_encode($currentlocations));
        
        $subpath = $this->argument('subpath');
        $containername = $subpath . '-web-1';
        
        $updatedlocations = [];
        
        foreach($currentlocations as $location)
        {
            // $this->info($location["path"]);
            if ($location["path"] == "/" . $subpath or $location["path"] == "/assets" . $subpath)
            {
                $this->warn($location["path"] . " : location skipped.");
                continue;
            }
            $this->info($location["path"] . " : on conserve cette configuration");
            array_push($updatedlocations, $location);
        }

        // $this->info(json_encode($updatedlocations));
        
        $response = Http::withToken($token)->put($BASEURL . 'nginx/proxy-hosts/' . $proxyid,
        ["locations" => $updatedlocations ]);

        if($response->ok() )
            $this->info("Update successful!");
        else
        {
            $this->error("Update failed!" . $response->body());
        }
        
        return 0;
    }
}
