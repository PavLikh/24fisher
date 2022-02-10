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
        //getMethod() // GET, POST ...
        // getUri()
        // getHeaders()
        // Do some work...
        // echo '<pre>';
            // var_dump($request->getMethod());

    
        // echo '</pre>'; die;
        if ($request->getMethod() == 'GET') {
            $query = $request->getQueryParams();
        } else {
            $query = $request->getParsedBody();
        }
        
        if (!empty($query)) {
            $body = json_encode($query);
            $test = new Test();
            $test->setAttribute('body', $body);
            $test->setAttribute('method', $request->getMethod());
            $test->save();
        }

        // $body = Test::query()->pluck('body', 'id')->all(); //
        // $query = Test::select('body', 'method')->orderBy('id', 'DESC')->get()->toArray(); //
        $query = Test::select()->orderBy('id', 'DESC')->get()->toArray(); //
        // $body = Test::query()->latest()->get()->toArray(); // there is no created_at column in table
        // $query = Test::all('body', 'method')->toArray(); //
        // echo '<pre>';
        // var_dump($query);
        // echo '</pre>'; die;
        $data['query'] = $query; 
        // Render and return a response:

        // $data['query'] = json_encode($request->getQueryParams());
        
        return new HtmlResponse($this->renderer->render(
            'app::hook-page-handler',
            //[] // parameters to pass to template
            $data
        ));
    }
}
