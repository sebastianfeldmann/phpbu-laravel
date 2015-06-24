<?php
namespace phpbu\Laravel\Configuration;

/**
 * Class ProxyTest
 *
 * @package    phpbu\Laravel
 * @author     Sebastian Feldmann <sebastian@phpbu.de>
 * @copyright  Sebastian Feldmann <sebastian@phpbu.de>
 * @license    http://www.opensource.org/licenses/MIT The MIT License (MIT)
 * @link       http://phpbu.de/
 */
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

    /**
     * Tests Proxy::keyExists
     */
    public function testKeyExists()
    {
        $test  = ['foo' => 'bar'];
        $proxy = new Proxy($test);

        $this->assertTrue($proxy->keyExists('foo'));
        $this->assertFalse($proxy->keyExists('false'));
    }

    /**
     * Tests Proxy::keysExist
     */
    public function testKeysExist()
    {
        $test  = ['foo' => 'bar', 'fiz' => ['baz' => 'buz']];
        $proxy = new Proxy($test);

        $this->assertTrue($proxy->keysExist(['foo', 'fiz.baz']));
        $this->assertFalse($proxy->keysExist(['fiz', 'buz']));
    }
}
