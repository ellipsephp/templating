<?php

namespace Pmall\Templating;

class Template
{
    private $file;

    private $data;

    public function __construct($file, array $data = [])
    {
        $this->file = $file;
        $this->data = $data;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function getData()
    {
        return $this->data;
    }
}
