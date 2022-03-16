<?php
namespace phpbu\Laravel\Cmd;

use phpbu\Laravel\Configuration\Exception;
use phpbu\Laravel\Configuration\Proxy;

/**
 * Class BackupTest
 *
 * @package    phpbu\Laravel
 * @author     Sebastian Feldmann <sebastian@phpbu.de>
 * @copyright  Sebastian Feldmann <sebastian@phpbu.de>
 * @license    http://www.opensource.org/licenses/MIT The MIT License (MIT)
 * @link       http://phpbu.de/
 */
class BackupTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Tests Cmd::fire
     */
    public function testFireOkLaravelStyle()
    {
        // create the result mok that is returned by the mock runner
        $result = $this->getMockBuilder('\\phpbu\\App\Result')
                       ->disableOriginalConstructor()
                       ->getMock();
        $result->expects($this->once())
               ->method('wasSuccessful')
               ->willReturn(true);

        // create the mock runner
        $runner = $this->getMockBuilder('\\phpbu\\App\\Runner')
                       ->disableOriginalConstructor()
                       ->getMock();
        $runner->expects($this->once())
               ->method('run')
               ->willReturn($result);

        // create a valid config proxy
        $proxy   = new Proxy(require __DIR__ . '/../../_files/config.minimal.php');

        // create a command mock so no actual option/argument parsing is done
        $command = $this->getMockBuilder('\\phpbu\\Laravel\\Cmd\\Backup')
                        ->setMethods(['option'])
                        ->setConstructorArgs([$runner, $proxy])
                        ->getMock();
        $command->expects($this->exactly(4))
                ->method('option')
                ->willReturn(false);

        $this->assertTrue($command->handle());
    }

    /**
     * Tests Cmd::fire
     */
    public function testLaravelStyleInvalidConfig()
    {
        $this->expectException(Exception::class);
        // create the mock runner
        $runner = $this->getMockBuilder('\\phpbu\\App\\Runner')
                ->disableOriginalConstructor()
                ->getMock();

        // create a invalid config proxy
        $proxy   = new Proxy(require __DIR__ . '/../../_files/config.invalid.php');

        // create a command mock so no actual option/argument parsing is done
        $command = $this->getMockBuilder('\\phpbu\\Laravel\\Cmd\\Backup')
                        ->setMethods(['option'])
                        ->setConstructorArgs([$runner, $proxy])
                        ->getMock();

        $command->handle();
    }

    /**
     * Tests Cmd::fire
     */
    public function testFireOkPhpbuStyle()
    {
        // create the result mok that is returned by the mock runner
        $factory = $this->getMockBuilder('\\phpbu\\App\Factory')
                        ->disableOriginalConstructor()
                        ->getMock();

        $result = $this->getMockBuilder('\\phpbu\\App\Result')
                       ->disableOriginalConstructor()
                       ->getMock();
        $result->expects($this->once())
               ->method('wasSuccessful')
               ->willReturn(true);

        // create the mock runner
        $runner = $this->getMockBuilder('\\phpbu\\App\\Runner')
                      ->disableOriginalConstructor()
                      ->getMock();
        $runner->expects($this->once())
               ->method('run')
               ->willReturn($result);
        $runner->expects($this->once())
               ->method('getFactory')
               ->willReturn($factory);

        // create a valid config proxy
        $proxy   = new Proxy(require __DIR__ . '/../../_files/config.phpbu.php');

        // create a command mock so no actual option/argument parsing is done
        $command = $this->getMockBuilder('\\phpbu\\Laravel\\Cmd\\Backup')
                        ->setMethods(['option'])
                        ->setConstructorArgs([$runner, $proxy])
                        ->getMock();
        $command->expects($this->exactly(3))
                ->method('option')
                ->willReturn(false);

        $this->assertTrue($command->handle());
    }
}
