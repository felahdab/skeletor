# Développement

- [Contraintes liées au routage des requêtes](#contraintes-routage)
    - [Préfixe de l'instance](#prefixe_instance)
    - [Laravel Sanctum](#laravel_sanctum)
    - [Laravel Ignition](#laravel_ignition)
    - [Debugbar](#debugbar)
    - [Larecipe](#larecipe)
    - [Impersonate](#impersonate)
    - [L5 Swagger](#l5swagger)
    - [Livewire](#livewire)
    - [Fichiers statiques](#fichiers_statiques)
- [Gestion des droits](#gestion_des_droits)
- [Mindef Connect](#mindef_connect)

Skeletor est le squelette d'application Web Intradef mis à la disposition des développeurs de la FAN par le FANLab.<br><br>

Ce squelette a notamment pour objectif de placer le développeur dans un environnement lui permettant de développer ses idées sans avoir à réinventer la roue.
Ainsi, les tâches normalement réalisées au tout début d'un projet ont déjà été réalisées, et le développeur n'a pas à s'en préoccuper.
Skeletor tire partie de l'expérience acquise sur le projet FFAST du GTR Toulon, et inclut donc des briques fonctionnelles requises ou utiles pour l'intégration dans Intradef (Mindef Connect en particulier, mais aussi envoi de mail Intradef et interrogation de l'Annudef), basées sur des technologies conformes au CCT afin de faciliter, le cas échéant, la validation du projet par la comilologie ministérielle.<br><br>

Skeletor est basé sur le framework Laravel et inclut également d'autres briques techniques classiques (Bootstrap, Livewire, Alpine.js). Destiné à être mis en oeuvre sur la plateforme de développement du FANLab, ce squelette d'application doit aussi composer avec quelques contraintes techniques inhabituelles qui sont décrites ci-dessous et que le développeur devra respecter s'il veut que son application fonctionne.
A l'usage, ces contraintes ne sont pas difficiles à intégrer et ne posent pas de grosse difficulté.

> {info} Cette documentation ne reprend pas la documentation des briques techniques utilisées. Pour parfaitement la comprendre, il faut que le développeur se soit déjà intéressé
> à la documentation du framework Laravel qui constitue la base de travail. Les informations ci-dessous viennent préciser comment le framework Laravel est mis en oeuvre dans
> le cadre particulier de la plateforme de développement du FANLab.<br><br>

<a name="contraintes-routage">

## Contraintes liées au routage des requêtes

Sur Intradef, il n'est pas possible d'obtenir rapidement une nouvelle entrée DNS afin de déclarer un nouveau domaine.
Il n'est pas non plus possible d'obtenir une délégation de gestion sur un sous-domaine (afin de pouvoir ensuite crééer à la demande des sous domaines).
Par conséquent, afin de pouvoir offrir des instances de développement à la demande, le FANLab a retenu une solution consistant à attribuer à chaque instance de développement un préfixe, qui constitue le premier élément des URL de l'application.<br><br>


> {info} Par exemple, si l'instance de développement se voit attribuer le prefixe ```toto```, toutes les URL de cette instance commenceront par 
> ```https://un-domaine-qui-va-bien.intradef.gouv.fr/toto/```<br><br>

Or, Laravel (comme la plupart des applications et/ou framework de développement Web) ne dispose pas de mécanisme particulier pour gérer ce genre de cas. Toutefois, le mécanisme de routage des requêtes de Laravel permet de configurer chaque route servie et facilite la définition d'un préfixe sur une ou plusieurs routes (
Voir la documentation de Laravel sur le Routage et sur les prefixes: <a href="https://laravel.com/docs/10.x/routing#route-group-prefixes">```https://laravel.com/docs/10.x/routing#route-group-prefixes```</a> )<br><br>

Il est donc très facile de rajouter un préfixe sur les routes déclarées dans une application. Toutefois, comme une application s'appuie généralement sur divers packages logiciels, ces derniers doivent pouvoir tenir compte du préfixe de l'instance pour s'intégrer comme il faut dans l'environnement. Or, si la déclaration d'un préfixe, ou des URL sous lesquelles les fonctionnalités de tel ou tel package sont servies n'est pas possible, il peut devenir très compliqué d'intégrer ce package dans l'environnement. Cette contrainte a donc un effet sur les packages pouvant être intégrés dans l'environnement.<br><br>

<a name="prefixe_instance">

### Configuration du préfixe de l'instance
Skeletor est donc déjà configuré pour tenir compte de cette contrainte et faciliter la vie du développeur.
Le fichier .env de l'application comprend la variable ```APP_PREFIX``` qui permet de définir le préfixe à appliquer à l'ensemble des routes de l'application.<br><br>

Le ```RouteServiceProvider``` fourni par défaut lors de la création d'un projet Laravel est modifié afin d'inclure ce préfixe à toutes les routes définies dans les fichiers ```web.php``` et ```api.php```:

```php 
public function map()
{
    Route::prefix(env('APP_PREFIX') . '/api')
        ->middleware('api')
        ->namespace($this->namespace)
        ->group(base_path('routes/api.php'));

    Route::prefix(env('APP_PREFIX'))
        ->middleware('web')
        ->namespace($this->namespace)
        ->group(base_path('routes/web.php'));
}
```

> {info} Si l'application renvoit une erreur 404 (la page n'existe pas), il peut-être pertinent de vérifier que le préfixe configuré dans le ```.env``` correspond bien au prefixe
> attribué à l'instance. Si ce n'est pas le cas, les requêtes reçues ne correspondront pas aux routes déclarées, ce qui entrainera une erreur 404 systématique<br><br>


### Prise en compte du préfixe de l'instance dans les packages déjà installés dans Skeletor
Quelques packages sont déjà installés dans Skeletor. Pour ces packages, le nécessaire a déjà été fait afin que le préfixe de l'instance soit bien pris en compte dans les routes 
déclarées.<br><br>

<a name="laravel_sanctum">

#### Laravel Sanctum
Le package  ```laravel/sanctum ``` est un package utilisé pour permettre l'authentification des requêtes au moyen de tokens plutôt qu'au travers d'un couple login/mot de passe. Les tokens sont notamment utilisés pour les accès aux API. 
Ce package déclare 1 route et prévoit un paramètre de configuration pour préciser un préfixe à utiliser pour cette route. Ce paramètre est donc configuré pour
utiliser la valeur de  ```APP_PREFIX```:

```php
   'prefix' => env('APP_PREFIX'),
```
<br><br>

<a name="laravel_ignition">

#### Laravel Ignition
Le package  ```spatie/laravel-ignition ``` est un package utilisé pour présenter les pages d'erreur sous une forme utile au développeur (stack trace, paramètres d'environnement, etc). 
Ce package déclare 3 routes et prévoit un paramètre de configuration pour préciser un préfixe à utiliser pour ces routes. Ce paramètre est donc configuré pour
utiliser la valeur de  ```APP_PREFIX```:

```php
/*
    |--------------------------------------------------------------------------
    | Housekeeping Endpoint Prefix
    |--------------------------------------------------------------------------
    |
    | Ignition registers a couple of routes when it is enabled. Below you may
    | specify a route prefix that will be used to host all internal links.
    |
    */

    'housekeeping_endpoint_prefix' => env('APP_PREFIX') . '/_ignition',
```
<br><br>

<a name="debugbar">

#### Débugbar
Le package ```barryvdh/laravel-debugbar``` est installé afin de faciliter le débug de votre application.
Ce package déclare 5 routes et prévoit un paramètre de configuration pour rajouter un préfixe. Ce paramètre est donc ajusté pour utiliser la valeur de ```APP_PREFIX```:<br><br>

```php
 /*
     |--------------------------------------------------------------------------
     | DebugBar route prefix
     |--------------------------------------------------------------------------
     |
     | Sometimes you want to set route prefix to be used by DebugBar to load
     | its resources from. Usually the need comes from misconfigured web server or
     | from trying to overcome bugs like this: http://trac.nginx.org/nginx/ticket/97
     |
     */
    'route_prefix' => env('APP_PREFIX')== '' ? '_debugbar':  env('APP_PREFIX') . '/_debugbar',
```
<br><br>

<a name="larecipe">

#### Larecipe
Le package ```binarytorch/larecipe``` est installé afin de faciliter la mise à disposition de la documentation.
Ce package déclare 5 routes et prévoit un paramètre de configuration pour préciser la route de base. Ce paramètre est donc ajusté pour utiliser le  ```APP_PREFIX```:<br><br>

```php
 /*
    |--------------------------------------------------------------------------
    | Documentation Routes
    |--------------------------------------------------------------------------
    |
    | These options configure the behavior of the LaRecipe docs basic route
    | where you can specify the url of your documentations, the location
    | of your docs and the landing page when a user visits /docs route.
    |
    |
    */

    'docs'        => [
        'route'   => '/' . env('APP_PREFIX') . '/docs',
        'path'    => '/resources/docs',
        'landing' => 'generalites',
        'middleware' => ['web'],
    ],
```
<br><br>

<a name="impersonate">

#### Impersonate
Le package ```lab404/laravel-impersonate``` est installé afin de faciliter le débug de votre application en vous permettant de prendre la place d'un autre utilisateur afin de
voir ce qu'il voit.<br><br>

Ce package ne déclare pas directement ses routes dans l'application, mais définit une macro ```impersonate``` qui permet de déclarer les routes en les rajoutant dans ```routes/web.php```.<br><br>

Etant donné que toutes les routes déclarées dans ```routes/web.php``` sont déjà préfixées avec ```APP_PREFIX```, les routes de Impersonate déclarées via ```Route::impersonate();``` sont également préfixées.<br><br>

<a name="l5swagger">

#### L5 Swagger
Le package ```darkaonline/l5-swagger``` est installé afin de faciliter définition et la documentation de points d'accès API.
Ce package déclare 4 routes et prévoit des paramètres de configuration pour préciser ces dernières. Ces paramètres sont donc ajustés pour utiliser le  ```APP_PREFIX```:<br><br>

```php
 'routes' => [
    /*
        * Route for accessing api documentation interface
    */
    'api' => env('APP_PREFIX'). '/api/documentation',
 ],

'defaults' => [
    'routes' => [
        /*
            * Route for accessing parsed swagger annotations.
        */
        'docs' => env('APP_PREFIX'). '/api/docs',

        /*
            * Route for Oauth2 authentication callback.
        */
        'oauth2_callback' => env('APP_PREFIX'). '/api/oauth2-callback',
    ]
]

```
<br><br>

<a name="livewire">

#### Livewire
Le package ```livewire/livewire``` permet de crééer des pages Web dynamiques sans avoir à se préoccuper de la partie Javascript (le développeur n'écrit que du PHP et du HTML).
Ce package déclare 6 routes mais ne prévoit aucun mécanisme pour préfixer ces routes. <br><br>

Ce sujet a été discuté au sein de l'équipe de développement: <a href="https://github.com/livewire/livewire/pull/2662">Issue 2662</a> et ne fera pas l'objet de modification dans l'immédiat. <br><br>

Afin de contourner cette difficulté, le package a été déclaré dans composer.json comme ne devant pas être auto-détecté et chargé par Laravel:
```json
"extra": {
        "laravel": {
            "dont-discover": [
                "livewire/livewire"
            ]
        }
    },
```
<br><br>

puis un  ```ServiceProvider``` spécifique a été rajouté au squelette d'application afin d'outrepasser la déclaration des routes du package livewire afin de préfixer ces dernières:

```php
<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route as RouteFacade;

use Livewire\LivewireServiceProvider;

class PrefixedLivewireServiceProvider extends LivewireServiceProvider
{
    protected function registerRoutes()
    {
        $prefix = config('livewire.route_prefix');
        
        RouteFacade::prefix($prefix)->group(function() {
            parent::registerRoutes();
        });

    }
}
```
<br><br>

Ce ```ServiceProvider``` utilise le paramètre de configuration rajouté dans la configuration de livewire, qui lui-même utilise la valeur du  ```APP_PREFIX```:

```php
 /*
    |--------------------------------------------------------------------------
    | Livewire Route Prefix
    |--------------------------------------------------------------------------
    |
    | Les routes Livewire seront prefixees par ce prefixe.
    |
    | Examples: "prefixe/avec/lequel/prefixer/les/routes/livewire"
    |
    */

    'route_prefix' => env('APP_PREFIX'),
```



et il est explicitement déclaré dans le fichier de configuration de l'application ```config/app.php``` pour être chargé au lancement de l'application.

```php
'providers' => [


        App\Providers\PrefixedLivewireServiceProvider::class,

    ],
```

<a name="fichiers_statiques">

### Prise en compte du préfixe de l'instance pour servir les fichiers statiques

L'ensemble de l'instance applicative (serveur Web, processeur PHP, serveur de base de données) est conditionné par le préfixe qui lui est attribué.
Or, les fichiers statiques (images, js, css, ou autres), c'est à dire ceux qui doivent être renvoyés par le serveur Web sans avoir à activer l'application PHP, doivent eux-aussi être accessibles depuis une URL intégrant le préfixe de l'instance.<br><br>

Pour cela, lors du déploiement de l'instance, un lien symbolique est crée de telle sorte que le dossier ```public/APP_PREFIX``` redirige sur le dossier ```public/assets```.<br><br>

De son côté, le serveur Web est configuré pour servir ```public/``` à la racine des requêtes.<br><br>

Ainsi, lorsqu'une requête ```/APP_PREFIX/toto``` parvient au serveur Web, ce dernier cherche dans le dossier ```public/APP_PREFIX/toto```. La création du lien symbolique renvoit donc la recherche dans le dossier ```public/assets/toto``` ce qui correspond au modèle normal d'une application Laravel.<br><br>

Pär ailleurs, le fichier ```.env``` inclut une variable d'environnement ```ASSET_URL``` qui permet de préciser à Laravel sous quelle URL les ressources statiques sont disponibles. Par défaut, cette variable d'environnement est configurée pour tenir compte de ```APP_PREFIX``` de la façon suivante:
```php
ASSET_URL="/${APP_PREFIX}"
```

Par conséquent, dans les vues Blade de l'application, il est possible d'utiliser les fonctions de Laravel pour générer les URL pointant vers les ressources statiques sans se préoccuper du préfixe de l'instance:
```php
<link rel="icon" type="image/png" sizes="32x32" href="{!! asset('assets/images/favicon-32x32.png') !!}">
```
L'URL générée par la fonction ```asset``` contiendra automatiquement le préfixe de l'instance. Dans l'exemple ci-dessous, l'URL renvoyée sera (où APP_PREFIX serait remplacé par le vrai préfixe de l'instance bien sûr):
```php
https://domaine-qui-va-bien.intradef.gouv.fr/APP_PREFIX/assets/images/favicon-32x32.png
```

<a name="gestion_des_droits">

## Gestion des droits
Par défaut, Skeletor est fourni avec le package ```spatie/laravel-permission``` installé.
Ce package est une des références en matière de gestion des rôles et des permissions des utilisateurs.<br><br>

En pratique, la mise en oeuvre de ce package dans Skeletor se traduit par:
  - Le fait que chaque route nommée correspond à une permission portant le même nom.
  - Si la route en question est protégée par le middleware ```permission```, alors l'accès n'est autorisé que si l'utilisateur dispose de la permission associée.<br><br>

Par défaut, toutes les routes de Skeletor nécessitant que l'utilisateur soit authentifié (middleware ```auth``` de Laravel) sont aussi protégées par le middleware ```permission``` qui vérifie que l'utilisateur a la bonne permission.<br><br>

```php
 Route::group(['middleware' => ['auth', 'permission']], function () {
    bla bla bla
 }
 ```

La commande ```artisan permission:create-permission-routes``` permet de crééer en base les permissions correspondant aux routes nommées, si elles n'existent pas encore.<br><br>

Par ailleurs, le ```AuthServiceProvider``` par défaut de l'application est modifié pour donner toutes les autorisations aux utilisateurs appartenant au groupe ```admin```:
```php
Gate::before(function ($user, $ability) {
    return $user->hasRole('admin') ? true : null;
});
```

<a name="mindef_connect">

## Mindef Connect

Skeletor inclue le nécessaire pour utiliser l'authentification Mindef Connect.<br><br>

Mindef Connect est une solution d'authentification centralisée reposant sur l'infrastructure d'Annudef. Cette solution repose sur un serveur OpenID basé sur la solution Keycloak,
disponible en opensource sur Internet.<br><br>

Afin de s'addosser à Mindef Connect, Skeletor inclue Laravel Socialite avec le provider complémentaire Keycloak.<br><br>

Les paramètres du provider sont configurés dans le .env:
```php
KEYCLOAK_CLIENT_ID=
KEYCLOAK_CLIENT_SECRET=
KEYCLOAK_REDIRECT_URI="https://pprod-ffast.intradef.gouv.fr/${APP_PREFIX}/auth/callback"
KEYCLOAK_BASE_URL="https://pprod-mindef-connect-ng-auth.intradef.gouv.fr/auth/"
KEYCLOAK_REALM='Intradef'
 ```

 Par ailleurs, 2 routes sont déclarées dans l'application:
```php
 Route::get('/auth/redirect', function () {
    return Socialite::driver('keycloak')->stateless()->redirect();
})->name('keycloak.login.redirect');
```
Cette première route peut-être associée à un bouton dans l'application pour rediriger l'utilisateur vers le serveur Mindef Connect. 

```php
Route::get('/auth/callback', [LoginController::class, 'login'])->name('keycloak.login.perform');
```
Cette seconde route reçoit le client lorsqu'il est redirigé par le serveur Mindef Connect.<br><br>

Le controlleur de Login ```LoginController``` peut alors récupérer le token et les information de l'utilisateur puis décider quoi faire. Dans Skeletor, si l'utilisateur existe en base, sa session est ouverte. Sinon, l'application donne la possibilité à l'utilisteur de laisser un message pour expliquer pourquoi il veut avoir accès à l'application, et enregistre la tentative qui est signalée aux administrateurs.

```php
public function login(Request $request)
    {
        $driver = Socialite::driver('keycloak');
        $driver->setHttpClient(new Client(["verify" => false]));

        $MCuser = $driver->stateless()->user();
        ...

```