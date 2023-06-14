<?php

namespace Symfony\Base\App\Controller\Comment;


use Symfony\Base\Shared\Comment\Aplication\GetCommentUseCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class CommentGetController
{
    public function __construct(private readonly GetCommentUseCase $getCommentUseCase)
    {
    }

    public function __invoke(Request $request, string $id)
    {
        return new JsonResponse($this->getCommentUseCase->__invoke($id)->toArray);
    }

}
