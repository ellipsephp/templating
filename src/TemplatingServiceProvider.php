<?php declare(strict_types=1);

namespace Ellipse\Templating;

use Interop\Container\ServiceProvider;

use Ellipse\Templating\Engines\Factories\PlatesFactory;
use Ellipse\Templating\Engines\Factories\TwigFactory;

class TemplatingServiceProvider implements ServiceProvider
{
    public function getServices()
    {
        return [
            // Provides an engine interface implementation specified by the end user.
            EngineInterface::class => function ($container) {

                return $container->get('templating.engine');

            },
        ];
    }
}
