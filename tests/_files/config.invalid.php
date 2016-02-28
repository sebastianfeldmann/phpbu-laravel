<?php
return [
    'phpbu' => [
        'directories' => [
            [
                'source' => [
                    'path'    => 'storage/uploads',
                    'options' => []
                ],
                'target' => [
                    'dirname'     => 'storage/backup/uploads',
                    'filename'    => 'dir.tar',
                    'compression' => 'bzip2'
                ]
            ]
        ],
        'databases' => [
            [
                'source' => [
                    'connection' => 'mysql',
                    'options' => []
                ],
                'target' => [
                    'dirname'     => 'storage/backup/db',
                    'filename'    => 'dump.sql',
                    'compression' => 'bzip2',
                ]
            ]
        ],
        'phpbu'  => null
    ],
    'database' => [
        'connections' => [
            'mysql' => [
                'driver'    => 'mysql',
                'host'      => 'localhost',
                'database'  => 'test',
                'username'  => 'root',
                'password'  => 'secret'
            ]
        ],
    ]
];
