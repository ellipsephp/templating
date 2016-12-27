<?php

namespace Pmall\Templating;

use Psr\Http\Message\ServerRequestInterface;

use Interop\Http\Middleware\ServerMiddlewareInterface;
use Interop\Http\Middleware\DelegateInterface;

abstract class Composer implements ServerMiddlewareInterface
{
    private $factory;

    abstract protected function getDefault();

    public function __construct(TemplateResponseFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Implements psr 15 middleware convention.
     *
     * @param \Psr\Http\Message\ServerRequestInterface  $request    the incoming request.
     * @param \Psr\Http\Message\DelegateInterface       $delegate   the next middleware to execute.
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function process()
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
        $defaults = $this->getDefaults();

        foreach ($defaults as $key => $value) {

            $this->factory->set($key, $value);

        }

        return $delegate->process($request);
    }
}
