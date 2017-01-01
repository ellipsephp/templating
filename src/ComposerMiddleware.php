<?php

namespace Pmall\Templating;

use Psr\Http\Message\ServerRequestInterface;

use Interop\Http\Middleware\ServerMiddlewareInterface;
use Interop\Http\Middleware\DelegateInterface;

class ComposerMiddleware implements ServerMiddlewareInterface
{
    private $factory;
    private $composer;

    public function __construct(TemplateResponseFactory $factory, ComposerInterface $composer)
    {
        $this->factory = $factory;
        $this->composer = $composer;
    }

    /**
     * Implements psr 15 middleware convention.
     *
     * @param \Psr\Http\Message\ServerRequestInterface  $request    the incoming request.
     * @param \Psr\Http\Message\DelegateInterface       $delegate   the next middleware to execute.
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        return $this->__invoke($request, $delegate);
    }

    /**
    * Get the child defaults and set them to the template response factory.
    *
    * @param \Psr\Http\Message\ServerRequestInterface  $request    the incoming request.
    * @param \Psr\Http\Message\DelegateInterface       $delegate   the next middleware to execute.
    * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $defaults = $this->composer->getDefaults($request);

        foreach ($defaults as $key => $value) {

            $this->factory->set($key, $value);

        }

        return $delegate->process($request);
    }
}