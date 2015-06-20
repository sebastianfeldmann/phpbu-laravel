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
     * @var array
     */
    private $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function get($key = null)
    {
        $conf = $this->config;
        if (null !== $key) {
            $keys = explode('.', $key);
            foreach ($keys as $k) {
                if (!array_key_exists($k, $conf)) {
                    throw new Exception('invalid configuration key: ' . $k);
                }
                $conf = $conf[$k];
            }
        }
        return $conf;
    }
}
