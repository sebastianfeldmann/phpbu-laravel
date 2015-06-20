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
    // keep at least the empty array 'directories' => []
    'directories' => [
        [
            'source' => [
                'path'    => 'storage/uploads',
                'options' => [],
            ],
            'target' => [
                'dirname'     => 'storage/backup/uploads',
                'filename'    => 'dir.tar',
                'compression' => 'bzip2',
            ],
            'sync' => [
                'filesystem' => 'dropbox',
                'path'       => '/backup/uploads',
            ]
        ]
    ],
    // keep at least the empty array 'databases' => []
    'databases' => [
        [
            'source' => [
                'connection' => 'mysql',
                'options'    => []
            ],
            'target' => [
                'dirname'     => 'storage/backup/db',
                'filename'    => 'dump.sql',
                'compression' => 'bzip2',
            ],
            'sync' => [
                'filesystem' => 'dropbox',
                'path'       => '/backup/db',
            ]
        ],
    ],
    /*
    |--------------------------------------------------------------------------
    | phpbu configuration
    |--------------------------------------------------------------------------
    |
    | If you want to use a phpbu.xml or phpbu.json configuration
    | put a path in here pointing to the phpbu configuration file.
    | This is deactivated by default so you can use the config above
    | to set up you backups.
    |
    */
    'phpbu' => null,
];
