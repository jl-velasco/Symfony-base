<?php

namespace Symfony\Base\App\Controller\VideoList;

use Symfony\Base\App\Controller\ApiController;
use Symfony\Base\VideoList\Aplication\GetVideoQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class GetVideoListController extends ApiController
{

    public function __invoke(string $id): JsonResponse
    {
        $response = $this->ask(
            new GetVideoQuery($id)
        );

        return new JsonResponse(
            $response->toArray(),
            Response::HTTP_OK
        );
    }
}