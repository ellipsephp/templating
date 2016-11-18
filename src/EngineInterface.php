<?php

namespace Pmall\Templating;

interface EngineInterface
{
    public function render($file, array $data = []);
}
