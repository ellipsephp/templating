<?php

namespace Ellipse\Templating\Engines\Factories;

use League\Plates\Engine as Plates;

use Ellipse\Templating\EngineInterface;
use Ellipse\Templating\Engines\Adapters\PlatesAdapter;

class PlatesFactory
{
    public function __invoke($path, $extension = null): EngineInterface
    {
        $plates = new Plates($path, $extension);

        return new PlatesAdapter($plates);
    }
}
