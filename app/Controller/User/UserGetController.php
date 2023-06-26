<?php
declare(strict_types=1);

namespace Symfony\Base\App\Controller\User;

use Symfony\Base\App\Controller\ApiController;
use Symfony\Base\User\Aplication\GetUserQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

final class UserGetController extends ApiController
{
    /** @throws \JsonException */
    public function __invoke(string $id, Request $request): Response
    {
        $reponse = $this->ask(
            new GetUserQuery($id)
        );

        return new JsonResponse(
            $reponse->toArray(),
            Response::HTTP_OK
        );
    }
}