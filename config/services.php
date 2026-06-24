<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'keycloak' => [
        'client_id' => env('KEYCLOAK_CLIENT_ID'),
        'client_secret' => env('KEYCLOAK_CLIENT_SECRET'),
        'redirect' => env('KEYCLOAK_REDIRECT_URI'),
        'base_url' => env('KEYCLOAK_BASE_URL'),
        'realms' => env('KEYCLOAK_REALM'),
    ],
    'recherche_annuaire' => [
        'base_url' => env('SKELETOR_RECHERCHE_ANNUAIRE_BASE_URL'),
    ],
    'intradef' => [
        'mail_tld' => env('SKELETOR_INTRADEF_MAIL_TLD'),
    ],
    'sic21' => [
        'mail_tld' => env('SKELETOR_SIC21_MAIL_TLD'),
    ],
    'rabbitmq' => [
        'host' => env('AMQP_HOST', 'rabbitmq'),
        'port' => env('AMQP_PORT', 5672),
        'user' => env('AMQP_USER', 'poseidon'),
        'password' => env('AMQP_PASSWORD', 'strongpassword'),
        'vhost' => env('AMQP_VHOST', '/'),
        'incoming_queue' => env('AMQP_INCOMING_QUEUE', 'from_agora'),
        'outgoing_exchange' => env('AMQP_OUTGOING_EXCHANGE', 'to_agora'),
        'source_nodename' => env('AMQP_SOURCE_NODENAME', 'skeletor'),
    ],
];
