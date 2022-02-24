<?php

declare(strict_types=1);

namespace App\Handler;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use App\Model\Request;

use function time;

class QueryHandler implements RequestHandlerInterface
{

    public function handle(ServerRequestInterface $request): ResponseInterface
    {

        $action = $request->getAttribute('action');
    	switch ($action) {
    		case 'delone':
    			$itemId = $request->getParsedBody()['id'];
//    			$itemId = 37;
    			return new JsonResponse(['action' => $this->deleteOne($itemId)]);
    			break;
            case 'showone':
                $itemId = $request->getParsedBody()['id'];
                return new JsonResponse(['action' => $this->getOne($itemId)]);
                break;
    		default:
    			# code...
    			break;
    	}

        // return new JsonResponse(['ack' => time()]);
        return new JsonResponse(['action' => 'Ok']);
    }

    private function deleteOne($itemId)
    {
    	$result = false;
    	if(Request::query()->where("id","=", $itemId)->exists()) {
    		$result = Request::query()->where("id","=", $itemId)->first()->delete();
    	}
    	return $result;
    }

    private function getOne($itemId)
    {
        $result = false;
        if(Request::query()->where("id","=", $itemId)->exists()) {
            $result = Request::query()->where("id","=", $itemId)->first();
        }
        return $result;
    }
}
