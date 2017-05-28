<?php declare(strict_types=1);

namespace Ellipse\Templating\Engines\Adapters;

use Ellipse\Templating\EngineInterface;

abstract class AbstractAdapter implements EngineInterface
{
    /**
     * The defaults values to use when rendering the template.
     *
     * @var array
     */
    private $defaults = [];

    /**
     * @inheritdoc
     */
    public function setDefault(string $key, $value): void
    {
        $this->defaults[$key] = $value;
    }

    /**
     * Return the default values merged with the given list of values.
     *
     * @param array $values
     * @return array
     */
    protected function mergeValues(array $values): array
    {
        return array_merge($this->defaults, $values);
    }
}
