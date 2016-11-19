<?php

namespace Pmall\Templating\Adapters;

use League\Plates\Engine;

use Pmall\Templating\EngineInterface;

class PlatesAdapter implements EngineInterface
{
    private $plates;

    public function __construct(Engine $plates, array $options = [])
    {
        $this->plates = $plates;

        $this->setExtensionIfSpecified($options);
    }

    public function render($file, array $data = [])
    {
        return $this->plates->render($file, $data);
    }

    private function setExtensionIfSpecified($options)
    {
        if (array_key_exists('extension', $options)) {

            $extension = $options['extension'] == '' ? null : $options['extension'];

            $this->plates->setFileExtension($extension);

        }
    }
}
