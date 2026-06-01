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

    public static function setQuery(array $query): bool
    {
        $users = [];
        $success = true;

        if ('intradef' == config('skeletor.reseau_de_deploiement')) {
            $cacheKey = 'annuaire_ldap_' . md5(serialize($query));

            if (Cache::has($cacheKey)) {
                $users = Cache::get($cacheKey);
            } else {
                try {
                    $raw = AnnudefLDAPRequestService::searchUsers(
                        nom: $query['nom'],
                        prenom: $query['prenom'],
                        mail: $query['email'],
                        entite: $query['unite']
                    );

                    $raw = Arr::map($raw, function ($value, $key) {
                        return NewUserDescriptionData::make($value['nom'], $value['prenomusuel'], $value['email'], $value['unites'], $value['nid'], $value['gradelong']);
                    });

                    $users = Arr::map($raw, fn ($item) => $item->toArray());

                    Cache::put($cacheKey, $users, now()->addMinutes(10));
                } catch (\Exception $e) {
                    $success = false;
                    $users = [];
                }
            }
        } elseif ('sic21' == config('skeletor.reseau_de_deploiement')) {
            $users = [];
        }

        static::setUsers($users);
        return $success;
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
