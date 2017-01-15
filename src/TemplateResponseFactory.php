<?php

namespace Pmall\Templating;

use Pmall\Http\Factories\Diactoros\HtmlResponseFactory;

class TemplateResponseFactory extends HtmlResponseFactory
{
    private $engine;

    private $defaults = [];

    public function __construct(EngineInterface $engine)
    {
        $this->engine = $engine;
    }

    public function set($key, $value)
    {
        $this->defaults[$key] = $value;
    }

    public function createResponse($code = 200, $file = '', array $data = [], array $headers = [])
    {
        $data = array_merge($this->defaults, $data);

        $html = $this->engine->render($file, $data);

        return parent::createResponse($code, $html, $headers);
    }
}
