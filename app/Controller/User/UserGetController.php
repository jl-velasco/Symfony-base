<?php
declare(strict_types=1);

namespace Symfony\Base\App\Controller\User;

use Symfony\Base\Shared\Domain\Bus\Query\QueryBus;
use Symfony\Base\User\Aplication\GetUserQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

final class UserGetController
{
    public function __construct(
        private readonly QueryBus $queryBus,
    )
    {
    }

    /** @throws \JsonException */
    public function __invoke(string $id, Request $request): Response
    {
        $reponse = $this->queryBus->ask(
            new GetUserQuery($id)
        );

        return new JsonResponse(
            $reponse->toArray(),
            Response::HTTP_OK
        );
    }
}