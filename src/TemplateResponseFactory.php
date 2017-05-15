<?php declare(strict_types=1);

namespace Pmall\Templating;

use Psr\Http\Message\ResponseInterface;

use Zend\Diactoros\Response\HtmlResponse;

class TemplateResponseFactory
{
    /**
     * The template engine.
     *
     * @var \Pmall\Templating\EngineInterface
     */
    private $engine;

    /**
     * The defaults values to inject when rendering the template.
     *
     * @var array
     */
    private $defaults = [];

    /**
     * Set up a template response factory with the given template engine.
     *
     * @param \Pmall\Templating\EngineInterface
     */
    public function __construct(EngineInterface $engine)
    {
        $this->engine = $engine;
    }

    /**
     * Set a default value to inject when rendering the template.
     *
     * @param string    $key
     * @param mixed     $value
     * @return void
     */
    public function set(string $key, $value): void
    {
        $this->defaults[$key] = $value;
    }

    /**
     * Use the engine to return a response from the given template file and data
     * to inject. Allow to specify a status code and a list of custom headers.
     *
     * @param string    $file
     * @param array     $data
     * @param int       $status
     * @param array     $headers
     * @return Psr\Http\Message\ResponseInterface
     */
    public function createResponse(string $file, array $data = [], $status = 200, array $headers = []): ResponseInterface
    {
        $data = array_merge($this->defaults, $data);

        $html = $this->engine->render($file, $data);

        return new HtmlResponse($html, $status, $headers);
    }
}
