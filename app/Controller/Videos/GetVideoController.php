<?php

declare(strict_types=1);

namespace Symfony\Base\App\Controller\Videos;

use Symfony\Base\App\Controller\ApiController;
use Symfony\Base\Shared\Domain\Bus\Query\QueryBus;
use Symfony\Base\Video\Aplication\GetVideoQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class GetVideoController extends ApiController
{
    /** @throws \JsonException */
    public function __invoke(string $id, Request $request): Response
    {
        $reponse = $this->ask(
            new GetVideoQuery($id)
        );

        return new JsonResponse(
            $reponse->toArray(),
            Response::HTTP_OK
        );
    }
}