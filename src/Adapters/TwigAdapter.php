<?php

namespace Pmall\Templating\Adapters;

use Pmall\Templating\EngineInterface;

class TwigAdapter implements EngineInterface
{
    private $twig;

    public function __construct(Twig_LoaderInterface $loader, $cache = null)
    {
        $this->twig = new Twig_Environment($loader, [
            'cache' => $cache,
        ]);
    }

    public function render($file, array $data = [])
    {
        return $this->twig->render($file, $data);
    }
}
