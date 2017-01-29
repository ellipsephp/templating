<?php

namespace Pmall\Templating\Engines\Factories;

use League\Plates\Engine as Plates;

use Pmall\Templating\EngineInterface;
use Pmall\Templating\Engines\Adapters\PlatesAdapter;

class PlatesFactory
{
    public function __invoke($parameters): EngineInterface
    {
        return new PlatesAdapter(new Plates(
            $parameters['views_dir'],
            $parameters['extension']
        ));
    }
}
