<?php namespace professionalweb;

use professionalweb\contracts\Platform;

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
    public static function get(string $key)
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
    private static function load(string $path)
    {
        $result = null;
        if (file_exists($path)) {
            $result = json_decode(file_get_contents($path), true);
        }
        return $result;
    }

    /**
     * Get driver configuration by platform and bundle ID
     *
     * @param string $platform
     * @param string $bundleId
     * @return array
     */
    public static function getConfigByBundleId(string $platform, string $bundleId) : array
    {
        $platforms = [Platform::IOS => 'apns', Platform::ANDROID => 'gcm'];
        $map = static::get('map');
        if (in_array($platform, array_keys($platforms)) && ($configId = static::getByPattern(array_keys($map[$platforms[$platform]]), $bundleId)) !== '') {
            return static::get($platforms[$platform])[$map[$platforms[$platform]][$configId]];
        }
        return [];
    }

    /**
     * Search string by pattern
     *
     * @param array $patternsArray
     * @param string $str
     * @return string
     */
    protected static function getByPattern(array $patternsArray, string $str) : string
    {
        foreach ($patternsArray as $pattern) {
            if ($pattern != '*' && fnmatch($pattern, $str)) {
                return $pattern;
            }
        }
        if (in_array('*', $patternsArray)) {
            return '*';
        }
        return '';
    }
}