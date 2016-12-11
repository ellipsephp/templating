<?php

namespace Pmall\Templating\Adapters;

use Twig_LoaderInterface;
use Twig_Environment;

use Pmall\Templating\EngineInterface;

class TwigAdapter implements EngineInterface
{
    private $twig;

    public function __construct(Twig_LoaderInterface $loader, array $twig_options)
    {
        $this->twig = new Twig_Environment($loader, $twig_options);
    }

    public function render($file, array $data = [])
    {
        return $this->twig->render($file, $data);
    }
}
