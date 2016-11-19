<?php

namespace Pmall\Templating;

class EngineFactory
{
    private static $factories = [];

    private function __construct()
    {
        //
    }

    public static function register($name, callable $factory)
    {
        static::$factories[$name] = $factory;
    }

    public static function has($name)
    {
        return array_key_exists($name, static::$factories);
    }

    public static function make($name, array $raw_config)
    {
        $factory = static::$factories[$name];

        $global_config = array_diff_key($raw_config, ['engine' => '', 'engines' => '']);

        $config = array_merge($global_config, $raw_config['engines'][$name]);

        return $factory($config);
    }
}
