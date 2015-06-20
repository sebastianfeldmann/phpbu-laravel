# phpbu-laravel
Laravel backup package - integrates phpbu with the laravel artisan command line tool.

[![Latest Stable Version](https://poser.pugx.org/phpbu/phpbu-laravel/v/stable.svg)](https://packagist.org/packages/phpbu/phpbu-laravel)
[![License](https://poser.pugx.org/phpbu/phpbu-laravel/license.svg)](https://packagist.org/packages/phpbu/phpbu-laravel)
[![Build Status](https://travis-ci.org/sebastianfeldmann/phpbu-laravel.svg?branch=master)](https://travis-ci.org/sebastianfeldmann/phpbu-laravel)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/sebastianfeldmann/phpbu-laravel/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/sebastianfeldmann/phpbu-laravel/?branch=master)

## Install

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