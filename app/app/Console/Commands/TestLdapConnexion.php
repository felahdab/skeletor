<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use RicorocksDigitalAgency\Soap\Facades\Soap;
use Illuminate\Support\Facades\Http;
use SimpleXMLElement;
use SoapClient;

class TestLdapConnexion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ffast:testldapconnexion';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test LDAP connexion';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $LDAPSERVER   = env("LDAPSERVER");
        // $LDAPSERVER   = "172.17.0.1:1234";
        $LDAPLOGIN   = env("LDAPLOGIN");
        $LDAPPASSWORD   = env("LDAPPASSWORD");
        $LDAPAUTHURL = env("LDAPAUTHURL");
        $LDAPANNUURL = env("LDAPANNUURL");
        
        $AUTHBASEURL = "https://" . $LDAPSERVER ."/" . $LDAPAUTHURL;
        $ANNUBASEURL = "https://" . $LDAPSERVER ."/" . $LDAPANNUURL;
        
        
        $response=Http::withBody(
        '<?xml version="1.0" encoding="UTF-8"?>
        <SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://ldap3.intradef.gouv.fr/LdapWS/Ws_srpcl_annusi_siclient/">
            <SOAP-ENV:Body>
                <ns1:searchUsers>
                    <mail>florian.el</mail>
                    <login>ffast.auth.tec</login>
                    <password>4zgOKjWAMyyOANhOemG6!</password>
                </ns1:searchUsers>
            </SOAP-ENV:Body>
        </SOAP-ENV:Envelope>', 'application/soap+xml')
        ->post($ANNUBASEURL);
        
        // $this->info($response->body());
        
        $result = new SimpleXMLElement($response->body(), null, 0, "http://schemas.xmlsoap.org/soap/envelope/");
        $xmlstr = $result
            ->Body
            ->children("ns1", true)
            ->children()
            ->response
            ->xml
            ;
        $xmlresult = new SimpleXMLElement($xmlstr);
        var_dump(trim($xmlresult
           ->userdata
           ->email
           )
           );
        
        return 0;
        // $context = stream_context_create([
            // 'ssl' => [
                // 'verify_peer' => false,
                // 'verify_peer_name'=>false,
                // 'allow_self_signed' => true,
             // ]
        // ]);
        
        // $soapclient = Soap::baseWsdl("wsdl.xml")
            // ->withOptions(['stream_context' => $context,
                           // 'location' => $ANNUBASEURL, 
                           // 'soap_version' => SOAP_1_2, 
                           // 'trace'=>true]);
        // $response = $soapclient->call('searchUsers', ['' , // tel
            // 'EL-AHDAB', // nom
            // '',  // prenom
            // '', //$mail, 
            // '', //$bdd, 
            // '', //$zone, 
            // '', //$localite, 
            // '', //$entite, 
            // '', //$fonction, 
            // '', //$nid, 
            // $LDAPLOGIN, 
            // $LDAPPASSWORD]);
        // $this->info(var_dump($response));
        
        // return 0;
        
        // $client = Soap::to("wsdl.xml")->withOptions(['stream_context' => $context,
        // 'soap_version'=>SOAP_1_2 , 'location' => $ANNUBASEURL ]);
        
        // $result = $client
            // ->functions();
        // $this->info(json_encode($result) . "\n");
        
        
        
        
        
            
        $result = $client->searchUsers($parameters);
        $this->info(var_dump($client));
            
        $node = soap_node([
            'tel' => "", //$tel, 
            'nom' => 'EL-AHDAB', //$nom, 
            'prenom' => "", //$prenom, 
            'mail' => "", //$mail, 
            'bdd' => "", //$bdd, 
            'zone' => "", //$zone, 
            'localite' => "", //$localite, 
            'entite' => "", //$entite, 
            'fonction' => "", //$fonction, 
            'nid' => "", //$nid, 
            'login' => $LDAPLOGIN, 
            'password' => $LDAPPASSWORD]);
        
        $result = $client->call('searchUsers', 
            null, //$tel, 
            'EL-AHDAB', //$nom, 
            null, //$prenom, 
            null, //$mail, 
            null, //$bdd, 
            null, //$zone, 
            null, //$localite, 
            null, //$entite, 
            null, //$fonction, 
            null, //$nid, 
            $LDAPLOGIN, 
            $LDAPPASSWORD);
        
        $request = $client->toto();
        $this->info(json_encode($result));
        
         //searchUsers(string $tel, string $nom, string $prenom, string $mail, string $bdd, string $zone, string $localite, string $entite, string $fonction, string $nid, string $login, string $password
        
        // $result = Soap::to($ANNUBASEURL)
            // ->withOptions(["context" => $context ])
            // ->call('searchUsers');
            
        
        
        // $result = Soap::to($AUTHBASEURL)
            // ->withOptions(['verifypeer' => false ])
            // ->call('authentification', [
                // 'login' => $LDAPLOGIN ,
                // 'password' => $LDAPPASSWORD,
                // ]);
        // $this->info(json_encode($result));
        return 0;
        
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
                $this->warn($location["path"] . " : location already exists: we overwrite.");
                continue;
            }
            $this->info($location["path"] . " : on conserve cette configuration");
            array_push($updatedlocations, $location);
        }

        $newlocation = ["path"=>"/" . $subpath,
                        "advanced_config"=>"",
                        "forward_scheme"=>"http",
                        "forward_host"=>$containername,
                        "forward_port"=>80];
        array_push($updatedlocations, $newlocation);
        
        // $newlocation = ["path"=>"/assets" . $subpath,
                        // "advanced_config"=>"",
                        // "forward_scheme"=>"http",
                        // "forward_host"=>$containername,
                        // "forward_port"=>80];
        // array_push($updatedlocations, $newlocation);
        
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
