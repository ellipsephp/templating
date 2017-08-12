<?php declare(strict_types=1);

namespace Ellipse\Templating;

use Ellipse\Contracts\Templating\EngineAdapterFactoryInterface;
use Ellipse\Contracts\Templating\EngineAdapterInterface;

class EngineFactory
{
    /**
     * The adapter factory.
     *
     * @var \Ellipse\Contracts\Templating\EngineAdapterFactoryInterface
     */
    private $adapter;

    /**
     * Set up a template engine factory with the given adapter factory.
     *
     * @param \Ellipse\Contracts\Templating\EngineAdapterFactoryInterface
     */
    public function __construct(EngineAdapterFactoryInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * Return a new template engine.
     *
     * @param string    $path
     * @param array     $options
     * @return \Ellipse\Contracts\Templating\EngineAdapterInterface
     */
    public function getEngine(string $path, $options = []): Engine
    {
        $adapter = $this->adapter->getEngine($path, $options);

        return new Engine($adapter);
    }
}
