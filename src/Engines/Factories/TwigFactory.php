<?php

namespace Ellipse\Templating\Engines\Factories;

use Twig_Loader_Filesystem;

use Ellipse\Templating\EngineInterface;
use Ellipse\Templating\Engines\Adapters\TwigAdapter;

class TwigFactory
{
    public function __invoke($path, $options): EngineInterface
    {
        $twig = new Twig_Loader_Filesystem($path);

        return new TwigAdapter($twig, $options);
    }
}
