<?php
namespace phpbu\Laravel\Cmd;

use Illuminate\Console\Command;
use phpbu\App\Configuration as PhpbuConfig;
use phpbu\App\Factory;
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
     * @return boolean
     * @throws \Exception
     */
    public function fire()
    {
        $phpbuConfigFile = $this->configProxy->get('phpbu.phpbu');
        // use a good old phpbu config file?
        if (!empty($phpbuConfigFile)) {
            // dummy code
            // TODO: use LoaderFactory to get the right config file loader to create a valid phpbu configuration
            $configuration = new PhpbuConfig();

        } else {
            Factory::register('sync', 'laravel-storage', '\\phpbu\\Laravel\\Backup\\Sync\\LaravelStorage');
            $translator    = new Translator();
            $configuration = $translator->translate($this->configProxy);
        }

        // add the command printer for some output
        $configuration->addLogger($this->createPrinter());

        $result = $this->runner->run($configuration);

        return $result->wasSuccessful();
    }

    /**
     * @return \phpbu\Laravel\Cmd\Printer
     */
    protected function createPrinter()
    {
        $verbose = (bool) $this->option('phpbu-verbose');
        $debug   = (bool) $this->option('phpbu-debug');
        return new Printer($this, $verbose, $debug);
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array(
            array('phpbu-verbose', null, InputOption::VALUE_NONE, 'Output more verbose information.'),
            array('phpbu-debug', null, InputOption::VALUE_NONE, 'Display debugging information during backup generation.'),
        );
    }
}
