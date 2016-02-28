<?php
namespace phpbu\Laravel\Backup\Sync;

class LaravelStorageTest extends \PHPUnit_Framework_TestCase
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
     *
     * @expectedException \phpbu\App\Exception
     */
    public function testSetupFail()
    {
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
