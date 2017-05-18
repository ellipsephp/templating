<?php declare(strict_types=1);

namespace Ellipse\Templating;

use Interop\Http\ServerMiddleware\MiddlewareInterface;

use Ellipse\Container\ReflectionContainer;
use Ellipse\Resolvers\AbstractResolver;

class ComposerResolver extends AbstractResolver
{
    /**
     * The application container.
     *
     * @var \Ellipse\Container\ReflectionContainer
     */
    private $container;

    /**
     * The template engine for which default values will be set.
     *
     * @var \Ellipse\Templating\EngineInterface
     */
    private $engine;

    /**
     * Sets up the action resolver with the application container and the
     * template engine for which default values will be set.
     *
     * @param \Ellipse\Container\ReflectionContainer    $container
     * @param \Ellipse\Templating\EngineInterface       $engine
     */
    public function __construct(ReflectionContainer $container, EngineInterface $engine)
    {
        $this->container = $container;
        $this->engine = $engine;
    }

    /**
     * Return whether this element is a composer.
     *
     * @param mixed $element
     * @return bool
     */
    public function canResolve($element): bool
    {
        return is_a($element, ComposerInterface::class, true);
    }

    /**
     * Resolve the middleware from the composer.
     *
     * @param \Psr\Container\ContainerInterface $composer
     * @return \Ellipse\Templating\ComposerMiddleware
     */
    public function getMiddleware($composer): MiddlewareInterface
    {
        return is_object($composer)
            ? new ComposerMiddleware($composer, $this->engine)
            : new ContainerComposerMiddleware($this->container, $composer, $this->engine);
    }
}
