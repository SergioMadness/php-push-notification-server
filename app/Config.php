<?php namespace professionalweb;

/**
 * Bot config
 * @package professionalweb
 */
class Config
{
    /**
     * Already loaded configuration
     *
     * @var array
     */
    private static $config;

    /**
     * Get config by key
     *
     * @param string $key
     * @return mixed
     */
    public static function get($key)
    {
        if (self::$config === null) {
            self::$config = static::load(__DIR__ . '/../config.json');
        }
        return isset(self::$config[$key]) ? self::$config[$key] : null;
    }

    /**
     * Load config
     *
     * @param string $path
     * @return mixed
     */
    private static function load($path)
    {
        $result = null;
        if (file_exists($path)) {
            $result = json_decode(file_get_contents($path), true);
        }
        return $result;
    }
}