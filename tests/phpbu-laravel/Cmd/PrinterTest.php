<?php
namespace phpbu\Laravel\Cmd;

/**
 * Class PrinterTest
 *
 * @package    phpbu\Laravel
 * @author     Sebastian Feldmann <sebastian@phpbu.de>
 * @copyright  Sebastian Feldmann <sebastian@phpbu.de>
 * @license    http://www.opensource.org/licenses/MIT The MIT License (MIT)
 * @link       http://phpbu.de/
 */
class PrinterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests Printer::write
     */
    public function testWrite()
    {
        $command = $this->getMockBuilder('\\phpbu\\Laravel\\Cmd\\Backup')
                        ->disableOriginalConstructor()
                        ->getMock();
        $command->expects($this->once())
                ->method('info');

        $printer = new Printer($command);
        $printer->write('foo');
    }

    /**
     * Tests Printer::writeWithColor
     */
    public function testWriteColored()
    {
        $command = $this->getMockBuilder('\\phpbu\\Laravel\\Cmd\\Backup')
                        ->disableOriginalConstructor()
                        ->getMock();
        $command->expects($this->once())
                ->method('info');

        // create printer with active debug
        $printer = new Printer($command, false, true);

        // create backup failed event mock
        $event = $this->getMockBuilder('\\phpbu\\App\\Event\\Backup\\Failed')
                      ->disableOriginalConstructor()
                      ->getMock();

        // call event handler to trigger colored write
        $printer->onBackupFailed($event);

        $this->assertTrue(true);
    }
}
