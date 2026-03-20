<?php

namespace App\Models;

use App\DataObjects\NewUserDescriptionData;
use App\Service\AnnudefLDAPRequestService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Sushi\Sushi;

class AnnuaireUser extends Model
{
    use Sushi;

    protected $schema = [
        'titre' => 'string',
        'nom' => 'string',
        'prenom' => 'string',
        'gradelong' => 'string',
        'gradecourt' => 'string',
        'nid' => 'string',
        'nomcomplet' => 'string',
        'nomaffiche' => 'string',
        'uid' => 'string',
        'email' => 'string',
        'unites' => 'string',
        'status' => 'string',
        'prenomusuel' => 'string',
        'categorystatus' => 'string',
        'categoryrank' => 'string',
        'familyname' => 'string',
    ];

    public static function setQuery(array $query)
    {
        if ('intradef' == config('skeletor.reseau_de_deploiement')) {
            $users = AnnudefLDAPRequestService::searchUsers(
                nom: $query['nom'],
                prenom: $query['prenom'],
                mail: $query['email'],
                entite: $query['unite']
            );
            // Ici, le retour est dans le format spécifique de la méthode d'interrogation de l'annuaire.
            // En l'occurence, Annudef.

            // Ci-dessous, on normalise les données en choisissant quel champs devient l'un des 3 champs nécessaires
            // pour créér un User local (nom, prenom et email).
            $users = Arr::map($users, function ($value, $key) {
                return NewUserDescriptionData::make($value['nom'], $value['prenomusuel'], $value['email'], $value['unites'], $value['nid'], $value['gradelong']);
            });
        } elseif ('sic21' == config('skeletor.reseau_de_deploiement')) {
            $users = [];
        }

        // Et ici, on retransforme les objets normalises en tableau pour la suite de Sushi.
        $users = Arr::map($users, function ($item) {
            return $item->toArray();
        });

        static::setUsers($users);
    }

    public static function setUsers($users)
    {
        Cache::put(
            'annuaire_search_'.session()->id(),
            $users,
            3000
        );
    }

    public function getRows()
    {
        return Arr::wrap(Cache::get('annuaire_search_'.session()->id()));
    }

    protected function sushiShouldCache()
    {
        return false;
    }
}
