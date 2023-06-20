<?php

namespace Symfony\Base\App\Controller\Comment;

use Symfony\Base\Comment\Application\GetListCommentUseCase;
use Symfony\Base\Shared\Domain\Exceptions\InvalidValueException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class CommentGetListController
{
    public function __construct(
        private GetListCommentUseCase $useCase
    )
    {
    }

    /**
     * @throws InvalidValueException
     */
    public function __invoke(string $videoId, Request $request): Response
    {
        return new JsonResponse($this->useCase->__invoke(
            $videoId
        )->toArray(),Response::HTTP_CREATED);
    }
}
