<?php

namespace Pmall\Templating;

use Interop\Container\ServiceProvider;

use League\Plates\Engine as Plates;
use Twig_Loader_Filesystem;

use Pmall\Templating\Adapters\PlatesAdapter;
use Pmall\Templating\Adapters\TwigAdapter;

class TemplatingServiceProvider implements ServiceProvider
{
    const KEY_PLATES = 'plates';
    const KEY_TWIG = 'twig';

    private $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

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

                return new ComposerResolver($container, $container->get(TemplateResponseFactory::class));

            },
            TemplateResponseFactory::class => function () {

                $engine = EngineFactory::make($this->config['engine'], $this->config);

                return new TemplateResponseFactory($engine);

            },
        ];
    }
}
