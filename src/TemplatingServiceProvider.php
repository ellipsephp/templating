<?php declare(strict_types=1);

namespace Pmall\Templating;

use Interop\Container\ServiceProvider;

use Ellipse\Contracts\Resolver\ResolverInterface;

use Ellipse\Container\ReflectionContainer;

class TemplatingServiceProvider implements ServiceProvider
{
    public function getServices()
    {
        return [
            // Provides a resolver appended with the composer resolver.
            ResolverInterface::class => function ($container, $previous = null) {

                $resolver = $container->get(ComposerResolver::class);

                return ! is_null($previous)
                    ? $previous()->withDelegate($resolver)
                    : $resolver;

            },

            // Provides the composer resolver to the end user.
            ComposerResolver::class => function ($container) {

                $container = new ReflectionContainer($container);
                $factory = $container->get(TemplateResponseFactory::class);

                return new ComposerResolver($container, $factory);

            },

            // Provides an engine interface implementation specified by the end user.
            EngineInterface::class => function ($container) {

                return $container->get('templating.engine');

            },

            // Provides a template response factory to the end user.
            TemplateResponseFactory::class => function ($container) {

                $engine = $container->get(EngineInterface::class);

                return new TemplateResponseFactory($engine);

            },
        ];
    }
}
