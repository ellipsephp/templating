<?php

namespace Pmall\Templating;

class EngineFactory
{
    private static $factories = [];

    public static function register($name, callable $factory)
    {
        static::$factories[$name] = $factory;
    }

    public static function make($name, $options)
    {
        $factory = static::$factories[$name];

        return $factory($options);
    }
}
