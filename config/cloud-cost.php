<?php

return [
    /*
    |--------------------------------------------------------------------------
    | custom config
    |--------------------------------------------------------------------------
    |
    */
    'providers' => [
        'aws_default' => [
            'driver' => 'aws',
            'config' => [
                'filter' => [
                    'Tags' => [
                        'Key' => 'Project',
                        'Values' => ['YourProjectName', 'your-project-name'],
                    ],
                ],
            ]
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | drivers
    |--------------------------------------------------------------------------
    |
    */
    'driver' => [
        'aws' => [
            'access_key' => env('AWS_ACCESS_KEY_ID'),
            'access_secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION', 'us-west-1'),
            'version' => '2017-10-25',
        ],
    ],
];
