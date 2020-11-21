<?php
namespace phpbu\Laravel\Cmd;

use Illuminate\Console\Command;
use phpbu\App\Result\PrinterCli;

/**
 * Class Printer
 *
 * @package    phpbu\Laravel
 * @author     Sebastian Feldmann <sebastian@phpbu.de>
 * @copyright  Sebastian Feldmann <sebastian@phpbu.de>
 * @license    http://www.opensource.org/licenses/MIT The MIT License (MIT)
 * @link       http://phpbu.de/
 */
class Printer extends PrinterCli
{
    /**
     * @var \Illuminate\Console\Command
     */
    protected $command;

    /**
     * Constructor
     *
     * @param \Illuminate\Console\Command $command
     * @param bool                        $verbose
     * @param bool                        $debug
     */
    public function __construct(Command $command, $verbose = false, $debug = false)
    {
        $this->command = $command;
        parent::__construct($verbose, false, $debug);
    }

    /**
     * Writes a buffer out with a color sequence if colors are enabled
     * In this case we just overwrite it to skip any color handling.
     *
     * @param string $color
     * @param string $buffer
     */
    protected function writeWithColor($color, $buffer): void
    {
        $this->write($buffer . PHP_EOL);
    }

    /**
     * @param string $buffer
     */
    public function write($buffer): void
    {
        $this->command->info($buffer);
    }
}
