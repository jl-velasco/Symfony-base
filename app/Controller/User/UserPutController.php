<?php
declare(strict_types=1);

namespace Symfony\Base\App\Controller\User;

use Symfony\Base\App\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Base\User\Application\UpsertUserUseCase;

final class UserPutController extends Controller
{
    public function __construct(
        private readonly UpsertUserUseCase $useCase
    )
    {
    }

    /** @throws \JsonException */
    public function __invoke(string $id, Request $request): Response
    {
        $data = $this->dataFromRequest($request);
        $this->useCase->__invoke(
            $id,
            $data['email'] ?? '',
            $data['name'] ?? '',
            $data['password'] ?? '',
        );

        return new Response(status: Response::HTTP_OK);
    }
}
