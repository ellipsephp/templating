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

    public static function make($name, array $config)
    {
        $factory = static::$factories[$name];

        return $factory($config);
    }
}
