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
        $post = $request->getParsedBody();
        $body = $request->getQueryParams();
        if (!empty($post)) {
            $body = json_encode($request->getParsedBody());
            $test = new Test();
            $test->setAttribute('body', $body);
            $test->save();   
        }

        if (!empty($body)) {
            $body = json_encode($request->getQueryParams());
            $test = new Test();
            $test->setAttribute('body', $body);
            $test->save();   
        }
            // $test1 = new Test();
            // $test = Test::select('body')->get();
            // $test1 = Test::query()->pluck('id', 'body')->get('body');
            // $test1 = Test::query()->pluck('body')->all();//work
      
            // $test = Test::query()->where('id', '=', 4)->first();//work
            // $test1 = $test->getAttributeValue('body');
            // $test1 = $test->getAttribute('body');

            $body = Test::query()->pluck('body', 'id')->all(); //
            // Test::query()->where("column","=", $accountId)->first();

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
