<?php

declare(strict_types=1);

namespace Symfony\Base\App\Controller\Videos;

use Symfony\Base\Video\Aplication\GetVideoUseCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class GetVideoController
{

    public function __construct(private readonly GetVideoUseCase $useCase)
    {
    }

    public function __invoke(string $id): JsonResponse
    {
        return new JsonResponse(
            $this->useCase->__invoke($id)->toArray(),
            Response::HTTP_OK
        );
    }
}