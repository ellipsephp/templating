<?php declare(strict_types=1);

namespace Ellipse\Templating;

use Interop\Container\ServiceProvider;

use Ellipse\Contracts\Templating\EngineInterface;

use Ellipse\Templating\Exceptions\NoAdapterProvidedException;
use Ellipse\Templating\Exceptions\NoTemplatesPathProvidedException;

class TemplatingServiceProvider implements ServiceProvider
{
    public function getServices()
    {
        return [
            'templating.path' => function ($container) {

                return null;

            },

            'templating.namespaces' => function ($container) {

                return [];

            },

            'templating.functions' => function ($container) {

                return [];

            },

            'templating.options' => function ($container) {

                return [];

            },

            Engine::class => function ($container) {

                // ensure an implementation of template engine is provided.
                if (! $container->has(EngineInterface::class)) {

                    throw new NoAdapterProvidedException;

                }

                // ensure a templates path is provided.
                if (is_null($container->get('templating.path'))) {

                    throw new NoTemplatesPathProvidedException;

                }

                // get the template engine implementation, the optional list of
                // template namespaces and the optional list of functions.
                $engine = $container->get(EngineInterface::class);
                $namespaces = $container->get('templating.namespaces');
                $functions = $container->get('templating.functions');

                // load the eventual namespaces.
                foreach ($namespaces as $namespace => $path) {

                    $engine->registerNamespace($namespace, $path);

                }

                // load the eventual functions.
                foreach ($functions as $name => $function) {

                    $engine->registerFunction($name, $function);

                }

                // provides the template engine.
                return new Engine($engine);

            },
        ];
    }
}
