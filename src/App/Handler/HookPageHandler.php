<?php

declare(strict_types=1);

namespace App\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;
use App\Model\Request;
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
//        $a = new Asd();

//        var_dump($a->count()); die; //
        //getMethod() // GET, POST ...
        // getUri()
        // getHeaders()
        // Do some work...
//        var_dump($request->getHeaderLine('host'));
//        var_dump($request->getHeaderLine('host1'));
//        var_dump($request->getHeader(['host', 'accept-encoding']));
//        $age = '36';
//        setcookie("age", $age, time() + 3600);
//        var_dump($request->getCookieParams());
//        $request->
//        var_dump($request->getRequestTarget());
//        var_dump($request->getUri()); // /hook
//        $a = serialize($request->getQueryParams());
//        var_dump(unserialize($a));

//die;

//        var_dump(date('r')); die;
//        $request->getBody(); die;
//        var_dump($request->); die;

    

            $query = $request->getQueryParams();
            $body = $request->getParsedBody();

        if (!empty($query) || !empty($body)) {
            $requestTable = new Request();
            if (!empty($query)) {
//                $query = json_encode($query);
                $query = serialize($query);
            }
            if (!empty($body)) {
                $body = json_encode($body);
                $requestTable->setAttribute('body', $body);
            }
            $requestTable->setAttribute('queryString', $query);
            $requestTable->setAttribute('method', $request->getMethod());
            $requestTable->setAttribute('dateTime', date('Y-m-d H:m:s'));
            $requestTable->setAttribute('userAgent', $request->getHeaderLine('user-agent'));
            $requestTable->setAttribute('acceptEncoding', $request->getHeaderLine('accept-encoding'));
            $requestTable->setAttribute('connection', $request->getHeaderLine('connection'));
            $requestTable->setAttribute('host', $request->getHeaderLine('host'));
            if ($request->getHeaderLine('x-signature')) {
                $requestTable->setAttribute('xSignature', $request->getHeaderLine('x-signature'));
            }
            if ($request->getHeaderLine('content-type')) {
                $requestTable->setAttribute('contentType', $request->getHeaderLine('content-type'));
            }
//            if ($request->getHeaderLine('content-length')) {
                $requestTable->setAttribute('contentLength', $request->getHeaderLine('content-length'));
//            }
            if ($request->getServerParams()["QUERY_STRING"]) {
                $requestTable->setAttribute('queryString', $request->getServerParams()["QUERY_STRING"]);
            }

            $requestTable->save();
        }

        // $body = Request::query()->pluck('body', 'id')->all(); //
        // $query = Request::select('body', 'method')->orderBy('id', 'DESC')->get()->toArray(); //

        $query = Request::select()->orderBy('id', 'DESC')->get()->toArray(); //
        // $body = Request::query()->latest()->get()->toArray(); // there is no created_at column in table
        // $query = Request::all('body', 'method')->toArray(); //
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
