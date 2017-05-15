<?php declare(strict_types=1);

namespace Pmall\Templating;

interface ComposerInterface
{
    /**
     * Return a list of values to add to the template response factory.
     *
     * @return array
     */
    public function getValues(): array;
}
