<?php declare(strict_types=1);

namespace Ellipse\Templating;

interface EngineInterface
{
    /**
     * Add a key => value pair to use when rendering.
     *
     * @param string    $key
     * @param mixed     $value
     * @return void
     */
    public function setDefault(string $key, $value): void;

    /**
     * Return a html string from a template file and a list of values.
     *
     * @param string    $file
     * @param array     $values
     * @return string
     */
    public function render(string $file, array $values = []): string;
}
