<?php

namespace Pmall\Templating;

use Interop\Container\ServiceProvider;

use League\Plates\Engine as Plates;
use Twig_Loader_Filesystem;

use Pmall\Templating\Adapters\PlatesAdapter;
use Pmall\Templating\Adapters\TwigAdapter;

use Pmall\Http\ResponseFactoryBuilder;

class TemplatingServiceProvider implements ServiceProvider
{
    const KEY_PLATES = 'plates';
    const KEY_TWIG = 'twig';

    public function getServices()
    {
        EngineFactory::register(static::KEY_PLATES, function ($config) {

            return new PlatesAdapter(new Plates(
                $config['views_dir'],
                $config['engines'][static::KEY_PLATES]['extension']
            ));

        });

        EngineFactory::register(static::KEY_TWIG, function ($config) {

            return new TwigAdapter(
                new Twig_Loader_Filesyste($config['views_dir']),
                $config['engines'][static::KEY_TWIG]
            );

        });

        return [
            ComposerResolver::class => function ($container) {

                $response_factory = $container->get(TemplateResponseFactory::class);

                return new ComposerResolver($container, $response_factory);

            },
            TemplateResponseFactory::class => function ($container) {

                $config = $container->get('templating');

                $engine = EngineFactory::make($config['engine'], $config);

                return new TemplateResponseFactory($engine);

            },
            ResponseFactoryBuilder::class => function ($container, $previous) {

                $factory = $container->get(TemplateResponseFactory::class);

                return $previous()->withFactory('template', $factory);

            },
        ];
    }
}
