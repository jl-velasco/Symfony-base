<?php

namespace Symfony\Base\App\Controller\Comment;

use Symfony\Base\Comment\Application\DeleteCommentUseCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CommentDeleteController
{
    public function __construct(
        private readonly DeleteCommentUseCase $useCase
    )
    {
    }

    public function __invoke(string $id, Request $request): Response
    {
        $this->useCase->__invoke($id);

        return new Response(status: Response::HTTP_NO_CONTENT);
    }
}
