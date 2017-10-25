<?php
namespace phpbu\Laravel\Cmd;

use Illuminate\Console\Command;
use phpbu\App\Configuration\Loader\Factory as PhpbuConfigLoaderFactory;
use phpbu\App\Factory as PhpbuFactory;
use phpbu\App\Runner;
use phpbu\Laravel\Configuration;
use phpbu\Laravel\Configuration\Translator;
use phpbu\Laravel\Configuration\Proxy;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class Backup
 *
 * @package    phpbu\Laravel
 * @author     Sebastian Feldmann <sebastian@phpbu.de>
 * @copyright  Sebastian Feldmann <sebastian@phpbu.de>
 * @license    http://www.opensource.org/licenses/MIT The MIT License (MIT)
 * @link       http://phpbu.de/
 */
class Backup extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'phpbu:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute the backup';

    /**
     * phpbu App runner.
     *
     * @var \phpbu\App\Runner
     */
    private $runner;

    /**
     * @var \phpbu\Laravel\Configuration\Proxy
     */
    private $configProxy;

    /**
     * Constructor.
     *
     * @param \phpbu\App\Runner                  $runner      Runner to execute the backups
     * @param \phpbu\Laravel\Configuration\Proxy $configProxy Laravel configuration proxy
     */
    public function __construct(Runner $runner, Proxy $configProxy)
    {
        $this->runner      = $runner;
        $this->configProxy = $configProxy;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @throws \Exception
     * @return bool
     */
    public function fire()
    {
        $configuration = $this->createConfiguration();

        // add a printer for some output
        $configuration->addLogger($this->createPrinter());

        // finally execute the backup
        $result = $this->runner->run($configuration);

        return $result->wasSuccessful();
    }

    /**
     * Creates a phpbu configuration.
     *
     * @return \phpbu\App\Configuration
     */
    protected function createConfiguration()
    {
        // check if a phpbu xml/json config file is configured
        $phpbuConfigFile = $this->configProxy->get('phpbu.phpbu');
        if (!empty($phpbuConfigFile)) {
            // load xml or json configurations
            $configLoader  = PhpbuConfigLoaderFactory::createLoader($phpbuConfigFile);
            $configuration = $configLoader->getConfiguration($this->runner->getFactory());
        } else {
            $this->validateConfig();
            // no phpbu config so translate the laravel settings
            $translator    = new Translator();
            $configuration = $translator->translate($this->configProxy);
            $configuration->setSimulate((bool) $this->option('phpbu-simulate'));
            // in laravel mode we sync everything using the Laravel Filesystems
            PhpbuFactory::register('sync', 'laravel-storage', '\\phpbu\\Laravel\\Backup\\Sync\\LaravelStorage');
        }
        return $configuration;
    }

    /**
     * Make sure we have a valid configuration.
     *
     * @throws \phpbu\Laravel\Configuration\Exception
     */
    protected function validateConfig()
    {
        if (!$this->configProxy->keysExist(
            [
                'phpbu.config',
                'phpbu.directories',
                'phpbu.databases'
            ]
        )) {
            throw new Configuration\Exception(
                'invalid configuration' . PHP_EOL .
                'please use the \'phpbu.php\' configuration file provided by \'phpbu-laravel\'' . PHP_EOL .
                'for details visit phpbu.de'
            );
        }
    }

    /**
     * Create a logger/printer to do some output.
     *
     * @return \phpbu\Laravel\Cmd\Printer
     */
    protected function createPrinter()
    {
        $verbose  = (bool) $this->option('phpbu-verbose');
        $debug    = (bool) $this->option('phpbu-debug');
        $simulate = (bool) $this->option('phpbu-simulate');
        return new Printer($this, $verbose, ($debug || $simulate));
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['phpbu-simulate', null, InputOption::VALUE_NONE, 'Perform a trial run with no changes made.'],
            ['phpbu-verbose', null, InputOption::VALUE_NONE, 'Output more verbose information.'],
            ['phpbu-debug', null, InputOption::VALUE_NONE, 'Display debugging information during backup generation.'],
        ];
    }
}
