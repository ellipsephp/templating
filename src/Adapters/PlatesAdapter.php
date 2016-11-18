<?php

namespace Pmall\Templating\Adapters;

use League\Plates\Engine;

use Pmall\Templating\EngineInterface;

class PlatesAdapter extends EngineInterface
{
    private $plates;

    public function __construct(Engine $plates)
    {
        $this->plates = $plates;
    }

    public function render($file, array $data = [])
    {
        $this->plates->render($file, $data);
    }
}
