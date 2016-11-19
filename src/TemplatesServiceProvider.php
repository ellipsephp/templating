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
        EngineInterface::class,
    ];

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function boot()
    {
        if ($this->shouldregisterEngine(static::KEY_PLATES)) {

            EngineFactory::register(static::KEY_PLATES, function ($config) {

                return new PlatesAdapter(new Plates($config['views_dir']), $config);

            });

        }

        if ($this->shouldregisterEngine(static::KEY_TWIG)) {

            EngineFactory::register(static::KEY_TWIG, function ($config) {

                return new TwigAdapter(new Twig_Loader_Filesystem($config['views_dir']), $config);

            });

        }
    }

    public function register()
    {
        $this->getContainer()->share(EngineInterface::class, function () {

            return EngineFactory::make($this->config['engine'], $this->config);

        });
    }

    private function shouldregisterEngine($engine)
    {
        return $this->config['engine'] == $engine and ! EngineFactory::has($engine);
    }
}
