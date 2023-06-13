<?php

declare(strict_types=1);

namespace Symfony\Base\App\Controller\User;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Base\Video\Aplication\DeleteVideoUseCase;

final class DeleteVideoController
{
    public function __construct(
        private readonly DeleteVideoUseCase $useCase
    ) {
    }

    /** @throws \JsonException */
    public function __invoke(string $id, Request $request): Response
    {
        $this->useCase->__invoke($id);
        return new Response(status: Response::HTTP_NO_CONTENT);
    }
}
