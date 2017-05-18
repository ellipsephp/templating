<?php declare(strict_types=1);

namespace Ellipse\Templating;

use Psr\Http\Message\ServerRequestInterface;

use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Interop\Http\ServerMiddleware\DelegateInterface;

class ComposerMiddleware implements MiddlewareInterface
{
    /**
     * The underlying composer.
     *
     * @var \Ellipse\Templating\ComposerInterface
     */
    private $composer;

    /**
     * The template engine.
     *
     * @var \Ellipse\Templating\EngineInterface
     */
    private $engine;

    /**
     * Set up a composer middleware with the composer providing values and the
     * template engine receiving those values.
     *
     * @param \Ellipse\Templating\ComposerInterface $composer
     * @param \Ellipse\Templating\EngineInterface   $engine
     */
    public function __construct(ComposerInterface $composer, EngineInterface $engine)
    {
        $this->composer = $composer;
        $this->engine = $engine;
    }

    /**
     * Get the composer and use its values to populate the template engine.
     *
     * @param \Psr\Http\Message\ServerRequestInterface  $request
     * @param \Psr\Http\Message\DelegateInterface       $delegate
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $values = $this->composer->getValues();

        foreach ($values as $key => $value) {

            $this->engine->setDefault($key, $value);

        }

        return $delegate->process($request);
    }
}
