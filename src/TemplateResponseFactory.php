<?php

use Pmall\Http\Factories\HtmlResponseFactory;

class TemplateResponseFactory extends HtmlResponseFactory
{
    private $engine;

    public function __construct(EngineInterface $engine)
    {
        $this->engine = $engine;
    }

    public function createResponse($code = 200, $file = '', array $data = [], array $headers = [])
    {
        $html = $this->engine->render($file, $data);

        return parent::createResponse($code, $html, $headers);
    }
}
