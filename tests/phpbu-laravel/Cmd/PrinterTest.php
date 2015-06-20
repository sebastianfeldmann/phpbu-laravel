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
        // TODO: test colored write
        // create printer with active debug
        // create backup failed event mock
        // call event handler to trigger colored write
        $this->assertTrue(true);
    }
}
