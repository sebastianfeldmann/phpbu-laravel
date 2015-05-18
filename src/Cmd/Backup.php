<?php
namespace phpbu\Laravel\Cmd;

use Illuminate\Console\Command;
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
     * Execute the console command.
     *
     * @return boolean
     */
    public function fire()
    {
        $this->info('phpbu - backup start');
        $this->info('phpbu - backup end');
        return true;
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array(
            array('option1', null, InputOption::VALUE_NONE, 'option without value.'),
            array('option2', null, InputOption::VALUE_REQUIRED, 'option with required value'),
        );
    }
}
