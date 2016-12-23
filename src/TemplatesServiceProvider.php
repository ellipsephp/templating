<?php

namespace Pmall\Templating;

use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;

use League\Plates\Engine as Plates;
use Twig_Loader_Filesystem;

use Pmall\Templating\Adapters\PlatesAdapter;
use Pmall\Templating\Adapters\TwigAdapter;

class TemplatesServiceProvider extends AbstractServiceProvider implements BootableServiceProviderInterface
{
    const KEY_PLATES = 'plates';
    const KEY_TWIG = 'twig';

    private $config;

    protected $provides = [
        TemplateResponseFactory::class,
    ];

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function boot()
    {
        EngineFactory::register(static::KEY_PLATES, function ($config) {

            return new PlatesAdapter(new Plates(
                $config['views_dir'],
                $config['engines'][static::KEY_PLATES]['extension']
            ));

        });

        EngineFactory::register(static::KEY_TWIG, function ($config) {

            return new TwigAdapter(
                new Twig_Loader_Filesystem($config['views_dir']),
                $config['engines'][static::KEY_TWIG]
            );

        });
    }

    public function register()
    {
        $this->getContainer()->share(TemplateResponseFactory::class, function () {

            $engine = EngineFactory::make($this->config['engine'], $this->config);

            return new TemplateResponseFactory($engine);

        });
    }
}
