<?php

return [
    'name' => 'Transformation',
    'user_settings' => [
        'notifications' => [
            'pour_fonctions' => [
                'daily'           => false,
                'weekly'          => false,
                'liste_fonctions' => []
            ],
            'pour_services' => [
                'daily'           => false,
                'weekly'          => false,
                'liste_services' => []
            ],
        ],
    ],
    'pageaccueilpossible' => [
        "Ma page d'accueil" => 'transformation::transformation.homeindex',
        'Bilan pour mon service' => "transformation::statistiques.statpourunservice",
        'Bilan global' => 'transformation::statistiques.statglobal',
        'Bilan par stage' => 'transformation::statistiques.statstage',
        'Suivi par marins' => 'transformation::transformation.index',
        'Suivi par stages' => 'transformation::transformation.indexparstage'
    ]
];
