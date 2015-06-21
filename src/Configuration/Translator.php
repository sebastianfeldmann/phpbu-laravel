<?php
namespace phpbu\Laravel\Configuration;

use phpbu\App\Configuration;
use phpbu\App\Configuration\Backup\Target;

/**
 * Class Translator
 *
 * @package    phpbu\Laravel
 * @author     Sebastian Feldmann <sebastian@phpbu.de>
 * @copyright  Sebastian Feldmann <sebastian@phpbu.de>
 * @license    http://www.opensource.org/licenses/MIT The MIT License (MIT)
 * @link       http://phpbu.de/
 */
class Translator
{
    /**
     * Configuration Proxy
     *
     * @var \phpbu\Laravel\Configuration\Proxy
     */
    private $proxy;

    /**
     * Configurable laravel backup types.
     *
     * @var array
     */
    private $types = [
        'directories' => 'directoryConfigToBackup',
        'databases'   => 'databaseConfigToBackup',
    ];

    /**
     * Translates the laravel configuration to a phpbu configuration.
     *
     * @param  \phpbu\Laravel\Configuration\Proxy $proxy
     * @return \phpbu\App\Configuration
     * @throws \phpbu\Laravel\Configuration\Exception
     */
    public function translate(Proxy $proxy)
    {
        $this->proxy   = $proxy;
        $laravelPhpbu  = $this->proxy->get('phpbu');
        $configuration = new Configuration();
        $configuration->setFilename($laravelPhpbu['config']);

        // walk the the configured backups
        foreach ($this->types as $type => $translationMethod) {
            // create a phpbu backup config
            foreach ($laravelPhpbu[$type] as $conf) {
                $backup = $this->{$translationMethod}($conf);
                $backup->setTarget($this->translateTarget($conf['target']));

                $this->addChecksIfConfigured($backup, $conf);
                $this->addSyncIfConfigured($backup, $conf);
                $this->addCleanupIfConfigured($backup, $conf);

                $configuration->addBackup($backup);
            }
        }

        return $configuration;
    }

    /**
     * Translate a laravel directory config to phpbu backup configuration.
     *
     * @param  array $dir
     * @return \phpbu\App\Configuration\Backup
     * @throws \phpbu\Laravel\Configuration\Exception
     */
    protected function directoryConfigToBackup(array $dir)
    {
        $backup = new Configuration\Backup($dir['source']['path'], false);
        // build source config
        $options = [
            'path' => $dir['source']['path'],
        ];

        // check for configuration options
        if (isset($dir['source']['options'])) {
            array_merge($options, $dir['source']['options']);
        }
        $backup->setSource(new Configuration\Backup\Source('tar', $options));
        return $backup;
    }

    /**
     * Translate a laravel db config to phpbu backup configuration.
     *
     * @param  array $db
     * @throws \phpbu\Laravel\Configuration\Exception
     * @return \phpbu\App\Configuration\Backup
     */
    protected function databaseConfigToBackup(array $db)
    {
        $connection = $this->getDatabaseConnectionConfig($db['source']['connection']);

        // translate laravel settings to source options
        $options = [
            'host'      => $connection['host'],
            'user'      => $connection['username'],
            'password'  => $connection['password'],
            'databases' => $connection['database'],
        ];

        // check for configuration options
        if (isset($db['source']['options'])) {
            array_merge($options, $db['source']['options']);
        }

        $backup = new Configuration\Backup('db-' . $db['source']['connection'], false);
        $backup->setSource(new Configuration\Backup\Source('mysqldump', $options));

        return $backup;
    }

    /**
     * Get a database connection configuration.
     *
     * @param  string $connection
     * @return array
     * @throws \Exception
     */
    protected function getDatabaseConnectionConfig($connection)
    {
        $connections = $this->proxy->get('database.connections');
        if (!isset($connections[$connection])) {
            throw new Exception('Unknown database connection: ' . $connection);
        }
        $config = $connections[$connection];
        if ($config['driver'] !== 'mysql') {
            throw new Exception('Currently only MySQL databases are supported using the laravel config');
        }
        return $config;
    }

    /**
     * Translate the target configuration.
     *
     * @param  array $config
     * @return Target
     * @throws \Exception
     */
    protected function translateTarget(array $config)
    {
        if (empty($config['dirname'])) {
            throw new Exception('invalid target: dirname has to be configured');
        }
        if (empty($config['filename'])) {
            throw new Exception('invalid target: filename has to be configured');
        }
        $dirname     = $config['dirname'];
        $filename    = $config['filename'];
        $compression = !empty($config['compression']) ? $config['compression'] : null;

        return new Target($dirname, $filename, $compression);
    }

    /**
     * Adds a check configuration to the given backup configuration.
     *
     * @param \phpbu\App\Configuration\Backup $backup
     * @param array                           $conf
     */
    protected function addChecksIfConfigured(Configuration\Backup $backup, array $conf)
    {
        if (isset($conf['check'])) {
            $backup->addCheck(
                new Configuration\Backup\Check(
                    $conf['check']['type'],
                    $conf['check']['value']
                )
            );
        }
    }

    /**
     * Adds a sync configuration to the given backup configuration.
     *
     * @param \phpbu\App\Configuration\Backup $backup
     * @param array                           $conf
     */
    protected function addSyncIfConfigured(Configuration\Backup $backup, array $conf)
    {
        if (isset($conf['sync'])) {
            $backup->addSync(
                new Configuration\Backup\Sync(
                    'laravel-storage',
                    false,
                    [
                        'filesystem' => $conf['sync']['filesystem'],
                        'path'       => $conf['sync']['path']
                    ]
                )
            );
        }
    }

    /**
     * Adds a cleanup configuration to the given backup configuration.
     *
     * @param \phpbu\App\Configuration\Backup $backup
     * @param array                           $conf
     */
    protected function addCleanupIfConfigured(Configuration\Backup $backup, array $conf)
    {
        if (isset($conf['cleanup'])) {
            $backup->setCleanup(
                new Configuration\Backup\Cleanup(
                    $conf['cleanup']['type'],
                    false,
                    $conf['cleanup']['options']
                )
            );
        }
    }
}
