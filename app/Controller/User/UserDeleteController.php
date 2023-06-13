<?php
declare(strict_types=1);

namespace Symfony\Base\App\Controller\User;

use Symfony\Base\User\Aplication\DeleteUserUseCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

final class UserDeleteController
{
    public function __construct(
        private readonly DeleteUserUseCase $useCase
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