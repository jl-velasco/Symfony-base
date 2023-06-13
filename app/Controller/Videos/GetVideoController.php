<?php
declare(strict_types=1);

namespace Symfony\Base\App\Controller\User;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Base\Video\Aplication\SearchVideoUseCase;

final class GetVideoController
{
    public function __construct(
        private readonly SearchVideoUseCase $useCase
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