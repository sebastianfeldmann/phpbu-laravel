<?php
namespace phpbu\Laravel\Configuration;

/**
 * Class TranslatorTest
 *
 * @package    phpbu\Laravel
 * @author     Sebastian Feldmann <sebastian@phpbu.de>
 * @copyright  Sebastian Feldmann <sebastian@phpbu.de>
 * @license    http://www.opensource.org/licenses/MIT The MIT License (MIT)
 * @link       http://phpbu.de/
 */
class TranslatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests Translator::translate
     */
    public function testTranslateMinimal()
    {
        $config        = require __DIR__ . '/../../_files/config.minimal.php';
        $translator    = new Translator();
        $configuration = $translator->translate(new Proxy($config));
        $backups       = $configuration->getBackups();

        $this->assertEquals(2, count($backups));
    }
}
