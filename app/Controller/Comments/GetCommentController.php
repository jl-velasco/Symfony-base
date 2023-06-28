<?php

namespace Symfony\Base\App\Controller\Comments;

use Symfony\Base\App\Controller\ApiController;
use Symfony\Base\Comment\Aplication\GetCommentQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class GetCommentController extends ApiController
{

    public function __invoke(string $id): JsonResponse
    {
        $response = $this->ask(
            new GetCommentQuery($id)
        );

        return new JsonResponse(
            $response->toArray(),
            Response::HTTP_OK
        );
    }
}