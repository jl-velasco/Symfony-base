<?php
declare(strict_types=1);

namespace Symfony\Base\App\Controller\Comment;

use Symfony\Base\Video\Aplication\GetCommentUseCase;
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