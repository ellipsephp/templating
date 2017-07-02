<?php

namespace Ellipse\Templating\Exceptions;

use RuntimeException;

use Ellipse\Contracts\Templating\EngineAdapterInterface;

class NoAdapterProvidedException extends RuntimeException implements TemplatingExceptionInterface
{
    public function __construct()
    {
        $msg = <<<EOT
            The container does not provide any implementation of %s.
            Make sure you installed a templating adapter package (ex: %s) and registered its service provider in the container.
EOT;

        parent::__construct(sprintf($msg, EngineAdapterInterface::class, implode(', ', [
            'ellipse/templating-plates',
            'ellipse/templating-twig',
        ])));
    }
}
