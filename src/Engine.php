<?php declare(strict_types=1);

namespace Ellipse\Templating;

use Ellipse\Contracts\Templating\EngineInterface;

class Engine
{
    /**
     * The underlying template engine to decorate.
     *
     * @var \Ellipse\Contracts\Templating\EngineInterface
     */
    private $engine;

    /**
     * The defaults values to use when rendering the template.
     *
     * @var array
     */
    private $defaults = [];

    /**
     * Set up a template engine decorator with the underlying template engine to
     * decorate.
     */
    public function __construct(EngineInterface $engine)
    {
        $this->engine = $engine;
    }

    /**
     * Add a key => value pair to use when rendering.
     *
     * @param string    $key
     * @param mixed     $value
     * @return void
     */
    public function setDefault(string $key, $value): void
    {
        $this->defaults[$key] = $value;
    }

    /**
     * Proxy the underlying template engine render method.
     *
     * @param string    $file
     * @param array     $data
     * @return string
     */
    public function render(string $file, array $data = []): string
    {
        $merged = array_merge($this->defaults, $data);

        return $this->engine->render($file, $merged);
    }
}
