<?php
namespace phpbu\Laravel\Configuration;


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
