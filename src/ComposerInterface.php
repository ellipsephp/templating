<?php declare(strict_types=1);

namespace Ellipse\Templating;

interface ComposerInterface
{
    /**
     * Return a list of values to add to the template response factory.
     *
     * @return array
     */
    public function getValues(): array;
}
