<?php

namespace Pmall\Templating;

use Interop\Container\ContainerInterface;

use Pmall\Core\ResolverInterface;

class ComposerResolver implements ResolverInterface
{
    /**
     * The application container.
     *
     * @var \Interop\Container\ContainerInterface
     */
    private $container;

    /**
     * The factory for which default values will be set.
     *
     * @var \Pmall\Templating\TemplateResponseFactory
     */
    private $factory;

    /**
     * Sets up the action resolver with the application container and the
     * factory for which default values will be set.
     *
     * @param \Interop\Container\ContainerInterface     $container  the application container.
     * @param \Pmall\Templating\TemplateResponseFactory $factory    the factory for which default values will be set.
     */
    public function __construct(ContainerInterface $container, TemplateResponseFactory $factory)
    {
        $this->container = $container;
        $this->factory = $factory;
    }

    /**
     * Return whether this element is a composer.
     *
     * @param mixed $element the element which may be a composer.
     * @return boolean
     */
    public function canResolve($element)
    {
        return is_a($element, ComposerInterface::class, true);
    }

    /**
     * Resolve the middleware from the composer.
     *
     * @param mixed $composer the composer to resolve.
     * @return callable
     */
    public function getMiddleware($composer)
    {
        $composer = is_string($composer)
            ? $this->container->get($composer)
            : $composer;

        return new ComposerMiddleware($this->factory, $composer);
    }
}
