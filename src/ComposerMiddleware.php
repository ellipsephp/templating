<?php declare(strict_types=1);

namespace Pmall\Templating;

use Psr\Http\Message\ServerRequestInterface;

use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Interop\Http\ServerMiddleware\DelegateInterface;

class ComposerMiddleware implements MiddlewareInterface
{
    /**
     * The underlying composer.
     *
     * @var \Pmall\Templating\ComposerInterface
     */
    private $composer;

    /**
     * The template response factory.
     *
     * @var \Pmall\Templating\TemplateResponseFactory
     */
    private $factory;

    /**
     * Set up a composer middleware with the composer providing values and the
     * template response factory receiving those values.
     *
     * @param \Pmall\Templating\ComposerInterface       $composer
     * @param \Pmall\Templating\TemplateResponseFactory $factory
     */
    public function __construct(ComposerInterface $composer, TemplateResponseFactory $factory)
    {
        $this->composer = $composer;
        $this->factory = $factory;
    }

    /**
     * Get the composer and use its values to populate the template response
     * factory.
     *
     * @param \Psr\Http\Message\ServerRequestInterface  $request
     * @param \Psr\Http\Message\DelegateInterface       $delegate
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $values = $this->composer->getValues();

        foreach ($values as $key => $value) {

            $this->factory->set($key, $value);

        }

        return $delegate->process($request);
    }
}
