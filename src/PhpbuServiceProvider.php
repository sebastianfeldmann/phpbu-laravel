<?php
namespace phpbu\Laravel;

use Illuminate\Support\ServiceProvider;

/**
 * Class PhpbuServiceProvider
 *
 * @package    phpbu\Laravel
 * @author     Sebastian Feldmann <sebastian@phpbu.de>
 * @copyright  Sebastian Feldmann <sebastian@phpbu.de>
 * @license    http://www.opensource.org/licenses/MIT The MIT License (MIT)
 * @link       http://phpbu.de/
 */
class PhpbuServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var boolean
     */
    protected $defer = true;

    /**
     * Bootstrap the application events, publish the phpbu config.
     */
    public function boot()
    {
        $this->publishes(
            array(
                __DIR__ . '/config/phpbu-config.php' => config_path('phpbu-config.php'),
            )
        );
    }

    /**
     * Register the phpbu service provider.
     */
    public function register()
    {
        $this->app['command.phpbu:backup'] = $this->app->share(
            function ($app) {
                return new Cmd\Backup();
            }
        );
        $this->commands(
            array('command.phpbu:backup')
        );
    }

    /**
     * Get the services provided by the phpbu provider.
     *
     * @return array<string>
     */
    public function provides()
    {
        return array(
            'command.phpbu:backup',
        );
    }
}
