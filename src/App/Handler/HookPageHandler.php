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

use function time;
use Mezzio\Helper;


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
//        var_dump($request->getHeaderLine('host'));
//        var_dump($request->getHeaderLine('host1'));
//        var_dump($request->getHeader(['host', 'accept-encoding']));

//        var_dump($request->getHeaders());
//        $a = json_encode($request->getHeaders());
//        var_dump($request->getRequestTarget());
//        var_dump($request->getUri());
//        $a = serialize($request->getQueryParams());
//        var_dump(unserialize($a));
//        var_dump($request->getQueryParams());

//        var_dump($request->getHeaders());
//        var_dump($request->getHeader('content-length'));
//        var_dump($request->getQueryParams());
//die;

//        var_dump(date('r')); die;
//        $request->getBody(); die;
//        var_dump($request->); die;

    

            $query = $request->getQueryParams();
            $body = $request->getParsedBody();

        if (!empty($query) || !empty($body)) {
            $test = new Test();
            if (!empty($query)) {
//                $query = json_encode($query);
                $query = serialize($query);
            }
            if (!empty($body)) {
                $body = json_encode($body);
                $test->setAttribute('body', $body);
            }
            $test->setAttribute('queryString', $query);
            $test->setAttribute('method', $request->getMethod());
            $test->setAttribute('dateTime', date('Y-m-d H:m:s'));
            $test->setAttribute('userAgent', $request->getHeaderLine('user-agent'));
            $test->setAttribute('acceptEncoding', $request->getHeaderLine('accept-encoding'));
            $test->setAttribute('connection', $request->getHeaderLine('connection'));
            $test->setAttribute('host', $request->getHeaderLine('host'));
            if ($request->getHeaderLine('x-signature')) {
                $test->setAttribute('xSignature', $request->getHeaderLine('x-signature'));
            }
            if ($request->getHeaderLine('content-type')) {
                $test->setAttribute('contentType', $request->getHeaderLine('content-type'));
            }
//            if ($request->getHeaderLine('content-length')) {
                $test->setAttribute('contentLength', $request->getHeaderLine('content-length'));
//            }
            if ($request->getServerParams()["QUERY_STRING"]) {
                $test->setAttribute('queryString', $request->getServerParams()["QUERY_STRING"]);
            }

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
        $data['index'] = 0;
        // Render and return a response:

        // $data['query'] = json_encode($request->getQueryParams());
        
        return new HtmlResponse($this->renderer->render(
            'app::hook-page',
            //[] // parameters to pass to template
            $data
        ));
    }
}
