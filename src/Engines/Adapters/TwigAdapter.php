<?php declare(strict_types=1);

namespace Pmall\Templating\Engines\Adapters;

use Twig_LoaderInterface;
use Twig_Environment;

use Pmall\Templating\EngineInterface;

class TwigAdapter implements EngineInterface
{
    /**
     * The underlying twig instance.
     *
     * @var \Twig_LoaderInterface
     */
    private $twig;

    /**
     * Set up a twig adapter with given twig loader instance.
     *
     * @param \League\Plates\Engine
     */
    public function __construct(Twig_LoaderInterface $loader, array $twig_options = [])
    {
        $this->twig = new Twig_Environment($loader, $twig_options);
    }

    /**
     * @inheritdoc
     */
    public function render(string $file, array $data = []): string
    {
        return $this->twig->render($file, $data);
    }
}
