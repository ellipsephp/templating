<?php

namespace Pmall\Templating;

use Psr\Http\Message\ServerRequestInterface;

interface ComposerInterface
{
    public function getDefaults(ServerRequestInterface $request);
}
