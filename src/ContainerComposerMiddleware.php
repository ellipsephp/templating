<?php declare(strict_types=1);

namespace Ellipse\Templating;

use Psr\Http\Message\ServerRequestInterface;

use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Interop\Http\ServerMiddleware\DelegateInterface;

use Ellipse\Container\ReflectionContainer;

class ContainerComposerMiddleware implements MiddlewareInterface
{
    /**
     * The reflection container wrapped around the application container.
     *
     * @var \Ellipse\Container\ReflectionContainer
     */
    private $container;

    /**
     * The composer fully qualified class name.
     *
     * @var string
     */
    private $classname;

    /**
     * The template response engine.
     *
     * @var \Ellipse\Templating\EngineInterface
     */
    private $engine;

    /**
    * Set up a composer middleware with the application container, the class
    * name of the composer providing values and the template engine receiving
    * those values.
     *
     * @param \Ellipse\Container\ReflectionContainer    $container
     * @param string                                    $classname
     * @param \Ellipse\Templating\EngineInterface       $engine
     */
    public function __construct(ReflectionContainer $container, string $classname, EngineInterface $engine)
    {
        $this->container = $container;
        $this->classname = $classname;
        $this->engine = $engine;
    }

    /**
     * Proxy the process method of a composer middleware using the composer
     * retrieved from the container.
     *
     * @param \Psr\Http\Message\ServerRequestInterface  $request
     * @param \Psr\Http\Message\DelegateInterface       $delegate
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $container = $this->container;
        $classname = $this->classname;

        // Retrieve the composer from the container if it contains it or make a
        // new composer by injecting the current request when needed.
        $overrides = [ServerRequestInterface::class => $request];

        $composer = $container->has($classname)
            ? $container->get($classname)
            : $container->make($classname, $overrides);

        // Proxy a composer middleware using this composer.
        $middleware = new ComposerMiddleware($composer, $this->engine);

        return $middleware->process($request, $delegate);
    }
}
