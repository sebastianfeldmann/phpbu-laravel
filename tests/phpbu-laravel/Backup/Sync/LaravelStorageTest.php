<?php
namespace phpbu\Laravel\Backup\Sync;

use phpbu\App\Exception;

class LaravelStorageTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Tests LaravelStorage::sync
     */
    public function testSetupOk()
    {
        $sync = new LaravelStorage();
        $sync->setup(['filesystem' => 'foo', 'path' => 'bar']);

        $this->assertTrue(true);
    }

    /**
     * Tests LaravelStorage::sync
     */
    public function testSetupFail()
    {
        $this->expectException(Exception::class);
        $sync = new LaravelStorage();
        $sync->setup(['path' => 'bar']);
    }

    /**
     * Tests LaravelStorage::simulate
     */
    public function testSimulate()
    {
        $target = $this->getMockBuilder('\\phpbu\\App\\Backup\\Target')
                       ->disableOriginalConstructor()
                       ->getMock();

        $result = $this->getMockBuilder('\\phpbu\\App\\Result')
                       ->disableOriginalConstructor()
                       ->getMock();

        $result->expects($this->once())
               ->method('debug');


        $sync = new LaravelStorage();
        $sync->setup(['filesystem' => 'foo', 'path' => 'bar']);

        $sync->simulate($target, $result);
    }
}
