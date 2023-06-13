<?php
declare(strict_types=1);

namespace Symfony\Base\App\Controller\Videos;

use Symfony\Base\Video\Aplication\GetVideoUseCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

final class VideoGetController
{
    public function __construct(
        private readonly GetVideoUseCase $useCase
    )
    {
    }

    /** @throws \JsonException */
    public function __invoke(string $uuid, Request $request): Response
    {
        return new JsonResponse(
            $this->useCase->__invoke($uuid)->toArray(),
            Response::HTTP_OK
        );
    }
}