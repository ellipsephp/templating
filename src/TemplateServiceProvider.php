<?php

namespace Pmall\Templating;

use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;

use League\Plates\Engine as Plates;
use Twig_Loader_Filesystem;

use Pmall\Templating\Adapters\PlatesAdapter;
use Pmall\Templating\Adapters\TwigAdapter;

class TemplateServiceProvider extends AbstractServiceProvider implements BootableServiceProviderInterface
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

            EngineFactory::register(static::KEY_PLATES, $this->config, function ($views_dir, $options) {

                return new PlatesAdapter(new Plates($views_dir));

            });

        }

        if ($this->shouldregisterEngine(static::KEY_TWIG)) {

            EngineFactory::register(static::KEY_TWIG, $this->config, function ($views_dir, $options) {

                return new TwigAdapter(new Twig_Loader_Filesystem($views_dir), $options);

            });

        }
    }

    public function register()
    {
        $this->getContainer()->share(EngineInterface::class, function () {

            $engine = $this->config['engine'];

            return EngineFactory::make($engine);

        });
    }

    private function shouldregisterEngine($engine)
    {
        return $this->config['engine'] == $engine and ! EngineFactory::has($engine);
    }
}
