<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Réseau de déploiement
    |--------------------------------------------------------------------------
    |
    | Cette option permet de préciser sur quel réseau l'application est déployée. Les valeurs possibles sont:
    |  - intradef
    |  - sic21
    |
    */

    'reseau_de_deploiement' => env('SKELETOR_RESEAU', "intradef"),

    /*
    |--------------------------------------------------------------------------
    | Politique de création des comptes pour les utilisateurs authentifies par Mindef Connect
    |--------------------------------------------------------------------------
    |
    | Par défaut, cette option est à false: même si l'utilisateur est authentifié par Mindef Connect
    | l'administrateur doit valider la demande de connexion pour crééer le compte en base
    | Si cette option est à true, lorsqu'un utilisateur est authentifié par Mindef Connect,
    | son compte est créé en base, et le role par defaut (voir ci-dessous) lui est attribué.
    |
    */

    'validation_automatique_des_comptes_mindef_connect' => env('APP_VALID_MDC', false),

    /*
    |--------------------------------------------------------------------------
    | Recherche d'équivalence avec les grades depuis le provider OpenID
    |--------------------------------------------------------------------------
    |
    | Par défaut, cette option est à true: Skeletor essaiera de chercher le grade
    | de l'utilisateur en fonction des données transmises par le provider OpenID
    | Fonctionne bien sur Intradef avec MindefConnect
    | Sur POLARIS Online, le provider ne renvoit pas de grade, donc doit être
    | désactivé (false)
    |
    */

    'matches_user_rank_if_possible' => false ,

    /*
    |--------------------------------------------------------------------------
    | Compte par defaut pour la creation automatique du compte
    |--------------------------------------------------------------------------
    */

    'groupe_par_defaut_des_nouveaux_comptes' => env('APP_ROLE_DEFAUT', "user"),

    /*
    |--------------------------------------------------------------------------
    | Page d'accueil par defaut
    |--------------------------------------------------------------------------
    | Ce parametre determine la route par defaut vers laquelle est redirige l'utilisateur
    | lorsqu'il n'a pas encore sélectionné de page par défaut individualisée.
    | Ce paramètre doit être le nom d'une route tel que défini dans web.php ou dans un Module.
    |
    | Attention: la page par defaut doit etre accessible meme aux utilisateurs non authentifies.
    | Sinon, le navigateur va tourner en boucle.
    */
    
    'page_par_defaut' => env('APP_PAGE_ACCUEIL', false),

    /*
    |--------------------------------------------------------------------------
    | Prefixe de l'instance
    |--------------------------------------------------------------------------
    | Ce paramètre détermine le préfixe à appliquer à toutes les urls déclarées
    | dans l'application.
    */

    'instance_prefix' => env('APP_PREFIX', "instance"),

    /*
    |--------------------------------------------------------------------------
    | Titre général de l'application
    |--------------------------------------------------------------------------
    | Ce paramètre détermine le titre général de l'application, tel que renseigné
    | dans le layout des vues (resources/views/layout/app-master.blade.php)
    */

    'instance_titre' => env('SKELETOR_TITLE', "Skeletor"),

    /*
    |--------------------------------------------------------------------------
    | Prefixe de l'instance
    |--------------------------------------------------------------------------
    | Ce parametre determine le prefixe de l'instance qui doit être rajoute a toutes
    | les urls générées.
    */
    
    'prefixe_instance' => env('APP_PREFIX', ''),

    /*
    |--------------------------------------------------------------------------
    | Activation du fonctionnement multi tenant
    |--------------------------------------------------------------------------
    |
    | Par défaut, cette option est à false. 
    | Lorsque cette option est à true, de multiples changements ont lieu dans l'application.
    | - les routes sont toutes modifiées pour rajouter un paramètre {tenant} destiné à identifier
    | le tenant souhaité.
    | - certains middlewares sont activés (pour déclancher le changement de tenant, y compris pour
    | les services comme Livewire)
    |
    | Attention: une fois qu'une instance est initialisée, elle ne peut être que multi tenant ou 
    | single tenant. Rien n'est prévu pour réaliser la transition à chaud entre les 2 modes.
    |
    */

    'multi_tenancy' => env('SKELETOR_MULTI_TENANCY', false),

    /*
    |--------------------------------------------------------------------------
    | Destinataire des mails lorsque l'application n'est pas en production
    |--------------------------------------------------------------------------
    |
    | Lorque l'application n'est pas en production (variable d'environnement APP_ENV != "production"),
    | tous les mails sont envoyés à l'adresse indiquée ci-dessous:
    |
    */
    'destinataire_email_non_production'=> env('SKELETOR_EMAIL_NON_PRODUCTION', 'nomail'),

    /*
    |--------------------------------------------------------------------------
    | Destinataire caché systématique des mails envoyés
    |--------------------------------------------------------------------------
    |
    | Lorque cette valeur est définie, elle est utilisée comme destinataire caché de tous les mails
    | produits depuis le composant MailEditComponent.
    |
    */
    'destinataire_systematique_bcc'=> env('SKELETOR_BCC_RECIPIENT', []),
    
];
