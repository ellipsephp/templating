<?php declare(strict_types=1);

namespace Ellipse\Templating\Engines\Adapters;

use League\Plates\Engine;

class PlatesAdapter extends AbstractAdapter
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
     * @param \League\Plates\Engine $plates
     */
    public function __construct(Engine $plates)
    {
        $this->plates = $plates;
    }

    /**
     * @inheritdoc
     */
    public function render(string $file, array $values = []): string
    {
        $merged = $this->mergeValues($values);

        return $this->plates->render($file, $merged);
    }
}
