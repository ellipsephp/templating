<?php

namespace Pmall\Templating;

class EngineFactory
{
    private static $factories = [];

    public static function register($name, array $config, callable $factory)
    {
        static::$factories[$name] = [$factory, $config];
    }

    public static function make($name)
    {
        list($factory, $config) = static::$factories[$name];

        return $factory($config);
    }
}
