<?php declare(strict_types=1);

namespace Ellipse\Templating;

use Interop\Container\ServiceProvider;

use Ellipse\Contracts\Templating\EngineInterface;

use Ellipse\Templating\Exceptions\NoAdapterProvidedException;

class TemplatingServiceProvider implements ServiceProvider
{
    public function getServices()
    {
        return [
            Engine::class => function ($container) {

                if (! $container->has(EngineInterface::class)) {

                    throw new NoAdapterProvidedException;

                }

                $engine = $container->get(EngineInterface::class);

                return new Engine($engine);

            },
        ];
    }
}
