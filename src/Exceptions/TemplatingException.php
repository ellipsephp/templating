<?php

namespace Ellipse\Templating\Exceptions;

use RuntimeException;

use Ellipse\Contracts\Templating\EngineInterface;

class TemplatingException extends RuntimeException implements TemplatingExceptionInterface
{
    public function __construct(string $msg)
    {
        parent::__construct($msg);
    }
}
