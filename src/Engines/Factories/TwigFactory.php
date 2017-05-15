<?php

namespace Pmall\Templating\Engines\Factories;

use Twig_Loader_Filesystem;

use Pmall\Templating\EngineInterface;
use Pmall\Templating\Engines\Adapters\TwigAdapter;

class TwigFactory
{
    public function __invoke($path, $options): EngineInterface
    {
        $twig = new Twig_Loader_Filesystem($path);

        return new TwigAdapter($twig, $options);
    }
}
