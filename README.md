# phpbu-laravel
Laravel backup package - integrates [phpbu](https://github.com/sebastianfeldmann/phpbu) with the laravel artisan command line tool.

[![Latest Stable Version](https://poser.pugx.org/phpbu/phpbu-laravel/v/stable.svg)](https://packagist.org/packages/phpbu/phpbu-laravel)
[![License](https://poser.pugx.org/phpbu/phpbu-laravel/license.svg)](https://packagist.org/packages/phpbu/phpbu-laravel)
[![Build Status](https://travis-ci.org/sebastianfeldmann/phpbu-laravel.svg?branch=master)](https://travis-ci.org/sebastianfeldmann/phpbu-laravel)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/sebastianfeldmann/phpbu-laravel/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/sebastianfeldmann/phpbu-laravel/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/sebastianfeldmann/phpbu-laravel/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/sebastianfeldmann/phpbu-laravel/?branch=master)

## Requirements
* PHP 5.5
* Laravel 5.*
* phpbu 2.1.*
* see [phpbu](https://github.com/sebastianfeldmann/phpbu) requirements for more details

## Installation

Use composer to install the package.

```bash
composer require phpbu/phpbu-laravel
```

Add the package ServiceProvider to your `config/app.php` configuration file.

```php
'providers' => [
    ...
    /*
     * phpbu Backup Service Providers...
     */
    phpbu\Laravel\ServiceProvider::class,
];
```

Finally create a configuration skeleton by publishing the package.

```bash
php artisan vendor:publish --provider="phpbu\Laravel\ServiceProvider"
```

## Configuration

After publishing the `ServiceProvider` a `phpbu.php` configuration file is created in your `config` directory.

```php
<?php
return [
    /*
    |--------------------------------------------------------------------------
    | laravel configuration
    |--------------------------------------------------------------------------
    |
    | This is activated as long as you don't specify a phpbu
    | configuration file at the bottom.
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
                'filesystem' => 's3',
                'path'       => '/backup/app',
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
    | Path to a phpbu configuration file.
    | You can use a phpbu.xml or phpbu.json configuration.
    | If you use one of those the configuration above will be ignored.
    | This is deactivated by default so you can setup your backup using
    | the configuration above
    */

    'phpbu' => null,
];

```
