<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use SimpleXMLElement;

use Illuminate\Http\Client\ConnectionException;

class AnnudefController extends Controller
{
    public static function searchUsersRequest($tel ='', $nom='' ,$prenom='' ,$mail='' , $bdd='' , $zone='' ,$localite ='' ,
            $entite='' ,$fonction='' , $nid='' , $login='', $password ='')
    {
        $template = '<?xml version="1.0" encoding="UTF-8"?>
        <SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://ldap3.intradef.gouv.fr/LdapWS/Ws_srpcl_annusi_siclient/">
            <SOAP-ENV:Body>
                <ns1:searchUsers>
                    <tel>TEL</tel>
                    <nom>NOM</nom>
                    <prenom>PRENOM</prenom>
                    <mail>MAIL</mail>
                    <bdd>BDD</bdd>
                    <zone>ZONE</zone>
                    <localite>LOCALITE</localite>
                    <entite>ENTITE</entite>
                    <fonction>FONCTION</fonction>
                    <nid>NID</nid>
                    <login>LOGIN</login>
                    <password>PASSWORD</password>
                </ns1:searchUsers>
            </SOAP-ENV:Body>
        </SOAP-ENV:Envelope>';
        $request = str_replace("TEL", $tel,$template);
        $request = str_replace("PRENOM", $prenom, $request);
        $request = str_replace("NOM", $nom, $request);
        $request = str_replace("MAIL", $mail, $request);
        $request = str_replace("BDD", $bdd, $request);
        $request = str_replace("ZONE", $zone, $request);
        $request = str_replace("LOCALITE", $localite, $request);
        $request = str_replace("ENTITE", $entite, $request);
        $request = str_replace("FONCTION", $fonction, $request);
        $request = str_replace("NID", $nid, $request);
        $request = str_replace("LOGIN", $login, $request);
        $request = str_replace("PASSWORD", $password, $request);
        return $request;
    }
    
    public static function searchUsers($tel ='', $nom='' ,$prenom='' ,$mail='' , $bdd='' , $zone='' ,$localite ='' ,
            $entite='' ,$fonction='' , $nid='')
    {
        
        $LDAPSERVER   = env("LDAPSERVER");
        $LDAPLOGIN   = env("LDAPLOGIN");
        $LDAPPASSWORD   = env("LDAPPASSWORD");
        $LDAPANNUURL = env("LDAPANNUURL");
        
        $ANNUBASEURL = "https://" . $LDAPSERVER ."/" . $LDAPANNUURL;
        
        $request = AnnudefController::searchUsersRequest($tel , $nom ,$prenom ,$mail , $bdd , $zone ,$localite  ,
            $entite ,$fonction , $nid , $LDAPLOGIN, $LDAPPASSWORD );
        
        $response=Http::timeout(intval(env("LDAPTIMEOUT")))
                ->withBody($request, 'application/soap+xml')
                ->post($ANNUBASEURL);
                
        $result = new SimpleXMLElement($response->body(), null, 0, "http://schemas.xmlsoap.org/soap/envelope/");
        $returncode = intval($result->Body->children("ns1", true)->children()->response->codeErreur);
        $results = [];
        
        if ($returncode == 0)
        {
            $xmlstr = $result
                ->Body
                ->children("ns1", true)
                ->children()
                ->response
                ->xml
                ;
            // $this->info($xmlstr);
                
            $xmlresult = new SimpleXMLElement($xmlstr);
           
            foreach ($xmlresult->children() as $userdata)
            {
                // var_dump($userdata);
                $userdatatbl=[
                    'titre' => trim($userdata->titre),
                    'nom' => trim($userdata->nom),
                    'prenom' => trim($userdata->prenom),
                    'gradelong' => trim($userdata->gradelong),
                    'gradecourt' => trim($userdata->gradecourt),
                    'nid' => trim($userdata->nid),
                    'nomcomplet' => trim($userdata->nomcomplet),
                    'nomaffiche' => trim($userdata->nomaffiche),
                    'uid' => trim($userdata->uid),
                    'email' => trim($userdata->email),
                    'unites' => trim($userdata->unites),
                    'status' => trim($userdata->nomusuel),
                    'prenomusuel' => trim($userdata->prenomusuel),
                    'categorystatus' => trim($userdata->categorystatus),
                    'categoryrank' => trim($userdata->categoryrank),
                    'familyname' => trim($userdata->familyname),
                
                ];
                // $this->info(json_encode($userdatatbl)); 
                array_push($results, $userdatatbl);
            }
        }
        else
        {
            // $this->error("Error code: " . $returncode . "\n");
            // $this->info("Request: \n");
            // $this->info($request . "\n");
        }
        return $results;
    }
    
    public function index()
    {
        return view('annudef.index');
    }
}
