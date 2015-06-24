<?php
namespace phpbu\Laravel\Configuration;

/**
 * Class Proxy
 *
 * @package    phpbu\Laravel
 * @author     Sebastian Feldmann <sebastian@phpbu.de>
 * @copyright  Sebastian Feldmann <sebastian@phpbu.de>
 * @license    http://www.opensource.org/licenses/MIT The MIT License (MIT)
 * @link       http://phpbu.de/
 */
class Proxy
{
    /**
     * Configuration
     *
     * @var array
     */
    private $config;

    /**
     * Constructor
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Returns true if a all keys exist false otherwise.
     *
     * @param  array $keys
     * @return bool
     */
    public function keysExist(array $keys)
    {
        foreach ($keys as $key) {
            if (!$this->keyExists($key)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Checks if a key exists.
     *
     * @param  string $key
     * @return bool
     */
    public function keyExists($key)
    {
        $exists = true;
        try {
            $this->get($key);
        } catch (Exception $e) {
            $exists = false;
        }
        return $exists;
    }

    /**
     * Return config value.
     * Use foo.bar to get $config['foo']['bar']
     *
     * @param  string $key
     * @throws \phpbu\Laravel\Configuration\Exception
     * @return mixed
     */
    public function get($key = null)
    {
        $conf = $this->config;
        if (null !== $key) {
            $path = '';
            $keys = explode('.', $key);
            foreach ($keys as $k) {
                $path .= $k;
                if (!array_key_exists($k, $conf)) {
                    throw new Exception('invalid configuration key ' . $key . ' at ' . $path);
                }
                $conf = $conf[$k];
            }
        }
        return $conf;
    }
}
