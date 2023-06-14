<?php

namespace Symfony\Base\App\Controller\Comment;

use Symfony\Base\Comment\Aplication\GetCommentUseCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

final class CommentGetController
{
    public function __construct(
        private readonly GetCommentUseCase $useCase
    )
    {
    }

    /** @throws \JsonException */
    public function __invoke(string $id, Request $request): Response
    {
        return new JsonResponse(
            $this->useCase->__invoke($id)->toArray(),
            Response::HTTP_OK
        );
    }
}