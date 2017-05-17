<?php declare(strict_types=1);

namespace Ellipse\Templating;

interface EngineInterface
{
    /**
     * Return a response from a template file and a list of data.
     *
     * @param string    $file
     * @param array     $data
     * @return string
     */
    public function render(string $file, array $data = []): string;
}
