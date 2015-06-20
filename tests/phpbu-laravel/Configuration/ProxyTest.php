<?php
namespace phpbu\Laravel\Configuration;


class ProxyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests Proxy::get
     */
    public function testGetAll()
    {
        $test  = ['foo' => 'bar'];
        $proxy = new Proxy($test);

        $this->assertEquals($test, $proxy->get());
    }

    /**
     * Tests Proxy::get
     */
    public function testGetDepthSingle()
    {
        $test  = ['foo' => 'bar'];
        $proxy = new Proxy($test);

        $this->assertEquals('bar', $proxy->get('foo'));
    }

    /**
     * Tests Proxy::get
     */
    public function testGetDepthMultiple()
    {
        $test  = [
            'foo' => 'a',
            'bar' => [
                'baz' => 'b',
                'fiz' => ['baz' => 'c']
            ]
        ];
        $proxy = new Proxy($test);

        $this->assertEquals('b', $proxy->get('bar.baz'));
        $this->assertEquals('c', $proxy->get('bar.fiz.baz'));
    }

    /**
     * Tests Proxy::get
     *
     * @expectedException \phpbu\Laravel\Configuration\Exception
     */
    public function testInvalidKey()
    {
        $test  = ['foo' => 'bar'];
        $proxy = new Proxy($test);

        $proxy->get('fiz');
    }
}
