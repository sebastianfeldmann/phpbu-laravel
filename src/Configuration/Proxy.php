<?php
namespace phpbu\Laravel\Configuration;

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
