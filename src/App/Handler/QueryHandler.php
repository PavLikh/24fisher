<?php

declare(strict_types=1);

namespace App\Handler;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use App\Model\Test;

use function time;

class QueryHandler implements RequestHandlerInterface
{

    public function handle(ServerRequestInterface $request): ResponseInterface
    {

        $action = $request->getAttribute('action');
    	switch ($action) {
    		case 'delone':
    			$itemId = $request->getParsedBody()['id'];
    			return new JsonResponse(['action' => $this->deleteOne($itemId)]);
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
    	if(Test::query()->where("id","=", $itemId)->exists()) {
    		$result = Test::query()->where("id","=", $itemId)->first()->delete();
    	}
    		
    	return $result;
    }
}
