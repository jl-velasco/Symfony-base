<?php

namespace Symfony\Base\App\Controller\Comment;

use Symfony\Base\Comment\Application\UpsertCommentUseCase;
use Symfony\Base\Shared\Domain\Exceptions\InvalidValueException;
use Symfony\Base\Shared\ValueObject\Uuid;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CommentUpSertController
{
    /**
     * @throws InvalidValueException
     */
    public function __invoke(Request $request, UpsertCommentUseCase $case): Response
    {
        $jsonData = $request->getContent();
        $data = json_decode($jsonData, true);

        $user = $case->__invoke(
            $data['id'] ?? Uuid::random(),
            $data['videoId'] ?? '',
            $data['comment'] ?? ''
        );

        return new JsonResponse($user,Response::HTTP_CREATED);
    }
}
