<?php declare(strict_types=1);

namespace Ellipse\Templating;

use Interop\Container\ServiceProvider;

use Ellipse\Contracts\Templating\EngineAdapterInterface;

use Ellipse\Templating\Exceptions\NoAdapterProvidedException;
use Ellipse\Templating\Exceptions\NoTemplatesPathProvidedException;

class TemplatingServiceProvider implements ServiceProvider
{
    public function getServices()
    {
        return [
            // Provides null for templating.path when no previous value is provided.
            'templating.path' => function ($container, $previous = null) {

                return is_null($previous) ? null : $previous();

            },

            // Provides [] for templating.namespace when no previous value is provided.
            'templating.namespaces' => function ($container, $previous = null) {

                return is_null($previous) ? [] : $previous();

            },

            // Provides [] for templating.functions when no previous value is provided.
            'templating.functions' => function ($container, $previous = null) {

                return is_null($previous) ? [] : $previous();

            },

            // Provides [] for templating.options when no previous value is provided.
            'templating.options' => function ($container, $previous = null) {

                return is_null($previous) ? [] : $previous();

            },

            // Provides a template engine using the template engine adapter implementation.
            Engine::class => function ($container) {

                // Ensure an implementation of template engine adapter is provided.
                if (! $container->has(EngineAdapterInterface::class)) {

                    throw new NoAdapterProvidedException;

                }

                // Ensure a templates path is provided.
                if (is_null($container->get('templating.path'))) {

                    throw new NoTemplatesPathProvidedException;

                }

                // Get the template engine adapter implementation, the optional
                // list of template namespaces and the optional list of functions.
                $adapter = $container->get(EngineAdapterInterface::class);
                $namespaces = $container->get('templating.namespaces');
                $functions = $container->get('templating.functions');

                // Load the eventual namespaces.
                foreach ($namespaces as $namespace => $path) {

                    $adapter->registerNamespace($namespace, $path);

                }

                // Load the eventual functions.
                foreach ($functions as $name => $function) {

                    $adapter->registerFunction($name, $function);

                }

                // Provides the template engine.
                return new Engine($adapter);

            },
        ];
    }
}
