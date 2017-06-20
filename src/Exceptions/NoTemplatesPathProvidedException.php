<?php

namespace Ellipse\Templating\Exceptions;

use RuntimeException;

use Ellipse\Contracts\Templating\EngineInterface;

class NoTemplatesPathProvidedException extends RuntimeException implements TemplatingExceptionInterface
{
    public function __construct()
    {
        $msg = <<<EOT
            The container does not provide a templates path.
            Make sure to provide a templates path for the container alias 'templating.path'.
EOT;

        parent::__construct(sprintf($msg));
    }
}
