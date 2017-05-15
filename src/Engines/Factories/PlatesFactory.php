<?php

namespace Pmall\Templating\Engines\Factories;

use League\Plates\Engine as Plates;

use Pmall\Templating\EngineInterface;
use Pmall\Templating\Engines\Adapters\PlatesAdapter;

class PlatesFactory
{
    public function __invoke($path, $extension = null): EngineInterface
    {
        $plates = new Plates($path, $extension);

        return new PlatesAdapter($plates);
    }
}
