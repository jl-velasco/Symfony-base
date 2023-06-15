<?php
declare(strict_types=1);

namespace Symfony\Base\App\Controller\Video;

use Symfony\Base\Video\Aplication\DeleteVideoUseCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

final class VideoDeleteController
{
    public function __construct(
        private readonly DeleteVideoUseCase $useCase
    )
    {
    }

    /** @throws \JsonException */
    public function __invoke(string $id, Request $request): Response
    {
        $this->useCase->__invoke($id);

        return new Response(status: Response::HTTP_NO_CONTENT);
    }
}