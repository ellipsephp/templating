<?php

namespace Pmall\Templating\Engines\Factories;

use Twig_Loader_Filesystem;

use Pmall\Templating\EngineInterface;
use Pmall\Templating\Engines\Adapters\TwigAdapter;

class TwigFactory
{
    public function __invoke($parameters): EngineInterface
    {
        return new TwigAdapter(
            new Twig_Loader_Filesystem($parameters['views_dir']),
            $parameters
        );
    }
}
