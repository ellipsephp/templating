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
            // Provides cwd for templating.path when no previous value is provided.
            'templating.path' => function ($container, $previous = null) {

                return is_null($previous) ? getcwd() : $previous();

            },

            // Provides [] for templating.namespace when no previous value is provided.
            'templating.namespaces' => function ($container, $previous = null) {

                return is_null($previous) ? [] : $previous();

            },

            // Provides [] for templating.functions when no previous value is provided.
            'templating.functions' => function ($container, $previous = null) {

                return is_null($previous) ? [] : $previous();

            },

            // Provides [] for templating.extensions when no previous value is provided.
            'templating.extensions' => function ($container, $previous = null) {

                return is_null($previous) ? [] : $previous();

            },

            // Provides [] for templating.options when no previous value is provided.
            'templating.options' => function ($container, $previous = null) {

                return is_null($previous) ? [] : $previous();

            },

            // Provides a template engine using the template engine adapter implementation.
            Engine::class => function ($container) {

                if (! $container->has(EngineAdapterInterface::class)) {

                    throw new NoAdapterProvidedException(EngineAdapterInterface::class);

                }

                $adapter = $container->get(EngineAdapterInterface::class);
                $namespaces = $container->get('templating.namespaces');
                $functions = $container->get('templating.functions');
                $extensions = $container->get('templating.extensions');

                // Load the eventual namespaces.
                foreach ($namespaces as $namespace => $path) {

                    $adapter->registerNamespace($namespace, $path);

                }

                // Load the eventual functions.
                foreach ($functions as $name => $function) {

                    $adapter->registerFunction($name, $function);

                }

                // Load the eventual extensions.
                foreach ($extensions as $extension) {

                    $adapter->registerExtension($extension);

                }

                // Provides the template engine.
                return new Engine($adapter);

            },
        ];
    }
}
