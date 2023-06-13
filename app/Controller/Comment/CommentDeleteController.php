<?php

namespace Symfony\Base\App\Controller\Comment;

use Symfony\Base\Video\Application\DeleteVideoUseCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CommentDeleteController
{
    public function __construct(
        private readonly DeleteVideoUseCase $useCase
    )
    {
    }

    public function __invoke(string $id, Request $request): Response
    {
        $this->useCase->__invoke($id);

        return new Response(status: Response::HTTP_NO_CONTENT);
    }
}
