<?php declare(strict_types=1);

namespace Ellipse\Templating;

use Interop\Container\ServiceProvider;

use Ellipse\Contracts\Templating\EngineInterface;

class TemplatingServiceProvider implements ServiceProvider
{
    public function getServices()
    {
        return [
            Engine::class => function ($container) {

                $engine = $container->get(EngineInterface::class);

                return new Engine($engine);

            },
        ];
    }
}
