<?php

namespace Symfony\Base\App\Controller\Comment;

use Symfony\Base\Comment\Application\GetListCommentUseCase;
use Symfony\Base\Comment\Application\UpsertCommentUseCase;
use Symfony\Base\Shared\Domain\Exceptions\InvalidValueException;
use Symfony\Base\Shared\ValueObject\Uuid;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CommentGetListController
{
    /**
     * @throws InvalidValueException
     */
    public function __invoke(Request $request, GetListCommentUseCase $case): Response
    {
        $jsonData = $request->getContent();
        $data = json_decode($jsonData, true);

        $comments = $case->__invoke(
            $data['videoId'] ?? ''
        );

        return new JsonResponse([
            'comments' => $comments
        ],Response::HTTP_CREATED);
    }
}
