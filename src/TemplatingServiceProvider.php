<?php

namespace Pmall\Templating;

use Interop\Container\ServiceProvider;

use Pmall\Http\ResponseFactoryBuilder;

class TemplatingServiceProvider implements ServiceProvider
{
    public function getServices()
    {
        return [
            ComposerResolver::class => function ($container) {

                $response_factory = $container->get(TemplateResponseFactory::class);

                return new ComposerResolver($container, $response_factory);

            },

            EngineInterface::class => function ($container) {

                return $container->get('templating.engine');

            },

            TemplateResponseFactory::class => function ($container) {

                $engine = $container->get(EngineInterface::class);

                return new TemplateResponseFactory($engine);

            },

            ResponseFactoryBuilder::class => function ($container, $previous) {

                $factory = $container->get(TemplateResponseFactory::class);

                return $previous()->withFactory('template', $factory);

            },
        ];
    }
}
