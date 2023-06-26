<?php

declare(strict_types=1);

namespace Symfony\Base\App\Controller\Videos;

use Symfony\Base\App\Controller\ApiController;
use Symfony\Base\Video\Aplication\GetVideoQuery;
use Symfony\Base\Video\Aplication\GetVideoQueryHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class GetVideoController extends ApiController
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