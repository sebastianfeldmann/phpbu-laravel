<?php
namespace phpbu\Laravel;

use Illuminate\Support\ServiceProvider as ServiceProviderLaravel;
use phpbu\Laravel\Configuration\Proxy;

/**
 * Class ServiceProvider
 *
 * @package    phpbu\Laravel
 * @author     Sebastian Feldmann <sebastian@phpbu.de>
 * @copyright  Sebastian Feldmann <sebastian@phpbu.de>
 * @license    http://www.opensource.org/licenses/MIT The MIT License (MIT)
 * @link       http://phpbu.de/
 */
class ServiceProvider extends ServiceProviderLaravel
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
            [__DIR__ . '/phpbu.php' => config_path('phpbu.php')]
        );
    }

    /**
     * Register the phpbu commands.
     */
    public function register()
    {
        $this->app->bind(Proxy::class, function($app) {
            return new Proxy($app['config']->all());
        });

        $this->commands(
            Cmd\Backup::class
        );
    }

    /**
     * Get the services provided by the phpbu provider.
     *
     * @return array<string>
     */
    public function provides()
    {
        return [
            Proxy::class,
        ];
    }
}
