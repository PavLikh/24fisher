<?php

declare(strict_types=1);

namespace App\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;
// use App\TestHandlerFactory;

class TestHandler implements RequestHandlerInterface
{
    /**
     * @var TemplateRendererInterface
     */
    private $renderer;
    private $config;

    public function __construct(TemplateRendererInterface $renderer, $config)
    {
        $this->renderer = $renderer;
        $this->config = $config;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        // Do some work...
        // Render and return a response:
        $data['test'] = $this->config['clientId'];
        
        return new HtmlResponse($this->renderer->render(
            'app::test-handler',
            //[] // parameters to pass to template
            $data
        ));
    }
}
