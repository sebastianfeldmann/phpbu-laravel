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
class TranslatorTest extends \PHPUnit\Framework\TestCase
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

        $this->assertCount(2, $backups);

        /** @var \phpbu\App\Configuration\Backup $backup */
        foreach ($backups as $backup) {
            $this->assertInstanceOf('\\phpbu\\App\\Configuration\\Backup\\Source', $backup->getSource());
            $this->assertInstanceOf('\\phpbu\\App\\Configuration\\Backup\\Target', $backup->getTarget());
        }
    }

    /**
     * Tests Translator::translate
     */
    public function testInvalidTargetNoDirname()
    {
        $this->expectException(Exception::class);
        $config = require __DIR__ . '/../../_files/config.minimal.php';
        unset($config['phpbu']['directories'][0]['target']['dirname']);

        $translator = new Translator();
        $translator->translate(new Proxy($config));
    }

    /**
     * Tests Translator::translate
     */
    public function testInvalidTargetNoFilename()
    {
        $this->expectException(Exception::class);
        $config = require __DIR__ . '/../../_files/config.minimal.php';
        unset($config['phpbu']['directories'][0]['target']['filename']);

        $translator = new Translator();
        $translator->translate(new Proxy($config));
    }

    /**
     * Tests Translator::translate
     */
    public function testInvalidDatabaseConnection()
    {
        $this->expectException(Exception::class);
        $config = require __DIR__ . '/../../_files/config.minimal.php';
        unset($config['database']['connections']['mysql']);

        $translator = new Translator();
        $translator->translate(new Proxy($config));
    }

    /**
     * Tests Translator::translate
     */
    public function testInvalidDatabaseDriver()
    {
        $this->expectException(Exception::class);
        $config = require __DIR__ . '/../../_files/config.minimal.php';
        $config['database']['connections']['mysql']['driver'] = 'mongodb';

        $translator = new Translator();
        $translator->translate(new Proxy($config));
    }

    /**
     * Tests Translator::translate
     */
    public function testTranslateComplete()
    {
        $config        = require __DIR__ . '/../../_files/config.complete.php';
        $translator    = new Translator();
        $configuration = $translator->translate(new Proxy($config));
        $backups       = $configuration->getBackups();

        $this->assertCount(3, $backups);
        $this->assertEquals('storage/uploads', $backups[0]->getName());
        $this->assertEquals('mysqldump', $backups[1]->getSource()->type);
        $this->assertEquals('pgdump', $backups[2]->getSource()->type);

        /** @var \phpbu\App\Configuration\Backup $backup */
        foreach ($backups as $backup) {
            foreach ($backup->getChecks() as $check) {
                $this->assertInstanceOf('\\phpbu\\App\\Configuration\\Backup\\Check', $check);
            }
            $this->assertInstanceOf('\\phpbu\\App\\Configuration\\Backup\\Cleanup', $backup->getCleanup());
        }
    }
}
