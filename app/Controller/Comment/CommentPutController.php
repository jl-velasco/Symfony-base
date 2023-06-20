<?php

namespace Symfony\Base\App\Controller\Comment;

use Symfony\Base\App\Controller\Controller;
use Symfony\Base\Comment\Application\UpsertCommentUseCase;
use Symfony\Base\Shared\Domain\Exceptions\InvalidValueException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CommentPutController extends Controller
{
    public function __construct(
        private readonly UpsertCommentUseCase $useCase
    )
    {
    }

    /**
     * @throws InvalidValueException
     */
    public function __invoke(string $id, Request $request): Response
    {
        $data = $this->dataFromRequest($request);

        $this->useCase->__invoke(
            $id,
            $data['videoId'] ?? '',
            $data['message'] ?? ''
        );

        return new Response(status: Response::HTTP_OK);
    }
}
