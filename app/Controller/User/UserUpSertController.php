<?php

namespace Symfony\Base\App\Controller\User;

use Symfony\Base\Shared\ValueObject\Uuid;
use Symfony\Base\User\Aplication\UpsertUserUseCase;
use Symfony\Base\Video\Application\UpsertVideoUseCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserUpSertController
{
    public function __invoke(Request $request, UpsertUserUseCase $case): Response
    {
        $jsonData = $request->getContent();
        $data = json_decode($jsonData, true);

        $user = $case->__invoke(
            $data['id'] ?? Uuid::random(),
            $data['email'] ?? '',
            $data['name'] ?? '',
            $data['password'] ?? ''
        );

        return new JsonResponse($user,Response::HTTP_CREATED);
    }
}
