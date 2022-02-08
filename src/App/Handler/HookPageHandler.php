<?php

declare(strict_types=1);

namespace App\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;
use App\Model\Test;
use Illuminate\Database\Eloquent\Collection;

class HookPageHandler implements RequestHandlerInterface
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
        $body = $request->getParsedBody();
        $query = $request->getQueryParams();
        if (!empty($body)) {
            $body = json_encode($request->getParsedBody());
            $test = new Test();
            $test->setAttribute('body', $body);
            $test->save();   
        }else if (!empty($query)) {
            $body = json_encode($request->getQueryParams());
            $test = new Test();
            $test->setAttribute('body', $body);
            $test->save();
        }

        $body = Test::query()->pluck('body', 'id')->all(); //
        // echo '<pre>';
        // var_dump($test1);
        // echo '</pre>'; die;
        $data['query'] = $body;    
        // Render and return a response:

        // $data['query'] = json_encode($request->getQueryParams());
        
        return new HtmlResponse($this->renderer->render(
            'app::hook-page-handler',
            //[] // parameters to pass to template
            $data
        ));
    }
}
