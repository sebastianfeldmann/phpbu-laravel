<?php
return [
    /*
    |--------------------------------------------------------------------------
    | laravel configuration
    |--------------------------------------------------------------------------
    |
    | This is activated as long you don't specify a phpbu
    | configuration file below.
    |
    */

    // no directories to backup
    // keep at least the empty array 'directories' => []

    'directories' => [
        [
            'source' => [
                'path'    => storage_path('app'),
                'options' => [],
            ],
            'target' => [
                'dirname'     => storage_path('/backup/app'),
                'filename'    => 'app-%Y%m%d-%H%i.tar',
                'compression' => 'bzip2',
            ],
            'sync' => [
                'filesystem' => 'dropbox',
                'path'       => '/backup/uploads',
            ]
        ]
    ],

    // no databases to backup
    // keep at least the empty array 'databases' => []

    'databases' => [
        [
            'source' => [
                'connection' => 'mysql',
                'options'    => []
            ],
            'target' => [
                'dirname'     => storage_path('backup/db'),
                'filename'    => 'dump-%Y%m%d-%H%i.sql',
                'compression' => 'bzip2',
            ],
            'sync' => [
                'filesystem' => 's3',
                'path'       => '/backup/db',
            ]
        ],
    ],
    'config' => __FILE__,

    /*
    |--------------------------------------------------------------------------
    | phpbu configuration
    |--------------------------------------------------------------------------
    |
    | Path to a valid phpbu configuration file.
    | You can use a phpbu.xml or phpbu.json configuration.
    | If you use one of those the configuration above will be ignored.
    | This is deactivated by default so you can setup your backup using
    | the configuration above
    */

    'phpbu' => null,
];
