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
                ],
                'check' => [
                    'type'  => 'MinSize',
                    'value' => '10B',
                ],
                'sync' => [
                    'filesystem' => 'local',
                    'path'       => '/backups/files'
                ],
                'cleanup' => [
                    'type' => 'capacity',
                    'options' => [
                        'size' => '500M'
                    ]
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
                ],
                'check' => [
                    'type'  => 'MinSize',
                    'value' => '10B',
                ],
                'sync' => [
                    'filesystem' => 's3',
                    'path'       => '/backups/db'
                ],
                'cleanup' => [
                    'type' => 'quantity',
                    'options' => [
                        'amount' => '20'
                    ]
                ]
            ]
        ],
        'config' => __FILE__,
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
