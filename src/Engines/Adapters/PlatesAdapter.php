<?php declare(strict_types=1);

namespace Ellipse\Templating\Engines\Adapters;

use League\Plates\Engine;

use Ellipse\Templating\EngineInterface;

class PlatesAdapter implements EngineInterface
{
    /**
     * The underlying plates instance.
     *
     * @var \League\Plates\Engine
     */
    private $plates;

    /**
     * Set up a plates adapter with the given plates instance.
     *
     * @param \League\Plates\Engine
     */
    public function __construct(Engine $plates)
    {
        $this->plates = $plates;
    }

    /**
     * @inheritdoc
     */
    public function render(string $file, array $data = []): string
    {
        return $this->plates->render($file, $data);
    }
}
