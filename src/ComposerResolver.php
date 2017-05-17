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
     * @var \Psr\Container\ContainerInterface
     */
    private $container;

    /**
     * The factory for which default values will be set.
     *
     * @var \Ellipse\Templating\TemplateResponseFactory
     */
    private $factory;

    /**
     * Sets up the action resolver with the application container and the
     * template response factory for which default values will be set.
     *
     * @param \Ellipse\Container\ReflectionContainer    $container
     * @param \Ellipse\Templating\TemplateResponseFactory $factory
     */
    public function __construct(ReflectionContainer $container, TemplateResponseFactory $factory)
    {
        $this->container = $container;
        $this->factory = $factory;
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
            ? new ComposerMiddleware($composer, $this->factory)
            : new ContainerComposerMiddleware($this->container, $composer, $this->factory);
    }
}
