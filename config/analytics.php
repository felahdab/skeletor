<?php

return [

    'enabled' => env('ANALYTICS_ENABLED', true),

    /**
     * Exclude.
     *
     * The routes excluded from page view tracking.
     */
    'exclude' => [
        //'/users/',
        //'/users/*',
        //'/users/*/edit',
    ],

    /**
     * Ignored IP addresses.
     *
     * The IP addresses excluded from page view tracking.
     */
    'ignoredIPs' => [
        // '192.168.1.1',
        //'172.19.0.1'
    ],

    /**
     * Ignore methods.
     *
     * The HTTP verbs/methods that should be excluded from page view tracking.
     */
    'ignoreMethods' => [
        // 'OPTIONS', 'POST',
    ],

];
