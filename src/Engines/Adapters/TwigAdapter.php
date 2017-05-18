<?php declare(strict_types=1);

namespace Ellipse\Templating\Engines\Adapters;

use Twig_LoaderInterface;
use Twig_Environment;

class TwigAdapter extends AbstractAdapter
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
    public function render(string $file, array $values = []): string
    {
        $merged = $this->mergeValues($values);

        return $this->twig->render($file, $merged);
    }
}
