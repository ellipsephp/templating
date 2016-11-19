<?php

namespace Pmall\Templating;

class EngineFactory
{
    private static $factories = [];

    private function __construct()
    {
        //
    }

    public static function register($name, array $config, callable $factory)
    {
        $views_dir = $config['views_dir'];
        $options = $config['engines'][$name];

        static::$factories[$name] = [$factory, $views_dir, $options];
    }

    public static function has($name)
    {
        return array_key_exists($name, static::$factories);
    }

    public static function make($name)
    {
        list($factory, $views_dir, $options) = static::$factories[$name];

        return $factory($views_dir, $options);
    }
}
