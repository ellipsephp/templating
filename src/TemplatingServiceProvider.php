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
            // Provides cwd as default value for templating.path.
            'templating.path' => function ($container, $previous = null) {

                return is_null($previous) ? getcwd() : $previous();

            },

            // Provides [] as default value for templating.options.
            'templating.options' => function ($container, $previous = null) {

                return is_null($previous) ? [] : $previous();

            },

            // Provides a template engine using the template engine adapter implementation.
            Engine::class => function ($container) {

                if (! $container->has(EngineAdapterInterface::class)) {

                    throw new NoAdapterProvidedException(EngineAdapterInterface::class);

                }

                $adapter = $container->get(EngineAdapterInterface::class);

                return new Engine($adapter);

            },
        ];
    }
}
