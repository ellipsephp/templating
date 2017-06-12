<?php declare(strict_types=1);

namespace Ellipse\Templating;

use Psr\Http\Message\ServerRequestInterface;

use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Interop\Http\ServerMiddleware\DelegateInterface;

use Ellipse\Container\ReflectionContainer;

abstract class AbstractComposerMiddleware implements MiddlewareInterface
{
    /**
     * The reflection container wrapped around the application container.
     *
     * @var \Ellipse\Container\ReflectionContainer
     */
    private $container;

    /**
     * The template engine.
     *
     * @var \Ellipse\Templating\Engine
     */
    private $engine;

    /**
     * Set up a composer middleware with the reflection container wrapped around
     * the application container and the template engine receiving the values.
     *
     * @param \Ellipse\Container\ReflectionContainer    $container
     * @param \Ellipse\Templating\Engine                $engine
     */
    public function __construct(ReflectionContainer $container, Engine $engine)
    {
        $this->container = $container;
        $this->engine = $engine;
    }

    /**
     * Return a composer callblack returning a list of key => value pairs to add
     * to the template engine.
     *
     * @return callable
     */
    abstract public function getComposer(): callable;

    /**
     * Get the composer and use its values to populate the template engine.
     *
     * @param \Psr\Http\Message\ServerRequestInterface  $request
     * @param \Psr\Http\Message\DelegateInterface       $delegate
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $composer = $this->getComposer();

        $overrides = [ServerRequestInterface::class => $request];

        $values = $this->container->call($composer, $overrides);

        foreach ($values as $key => $value) {

            $this->engine->setDefault($key, $value);

        }

        return $delegate->process($request);
    }
}
