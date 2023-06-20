<?php
declare(strict_types=1);

namespace Symfony\Base\App\Controller\Video;

use Symfony\Base\App\Controller\Controller;
use Symfony\Base\Video\Application\GetVideoUseCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

final class VideoGetController extends Controller
{
    public function __construct(
        private readonly GetVideoUseCase $useCase
    )
    {
    }

    /** @throws \JsonException */
    public function __invoke(string $id, Request $request): Response
    {
        return new JsonResponse(
            $this->useCase->__invoke($id)->toArray(),
            Response::HTTP_OK
        );
    }
}
