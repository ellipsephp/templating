<?php

namespace Pmall\Formatting\Formatters;

use Pmall\Formatting\FormatterInterface;

use Zend\Diactoros\Response\HtmlResponse;

class TemplateFormatter implements FormatterInterface
{
    private $engine;

    public function __construct(EngineInterface $engine)
    {
        $this->engine = $engine;
    }

    public function canFormat($something)
    {
        return $something instanceof Template;
    }

    public function getFormattedResponseFrom($expected_format, $template)
    {
        if ($expected_format == 'text/html') {

            $file = $template->getFile();
            $data = $template->getData();

            $content = $this->engine->render($file, $data);

            return new HtmlResponse($content);

        }

        return $array;
    }
}
