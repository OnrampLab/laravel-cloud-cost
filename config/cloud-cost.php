<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Key Provider Name
    |--------------------------------------------------------------------------
    |
    */
    'default' => env('CLOUD_COST_PROVIDERS', ['aws']),

    /*
    |--------------------------------------------------------------------------
    | Key Providers
    |--------------------------------------------------------------------------
    |
    | Configure the provider information for each service that
    | is used by your application.
    |
    | Drivers: "local", "aws"
    |
    */
    'providers' => [
        'aws' => [
            'driver' => 'aws',
            'access_key' => env('AWS_ACCESS_KEY_ID'),
            'access_secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION', 'us-west-1'),
        ],
    ],
];
