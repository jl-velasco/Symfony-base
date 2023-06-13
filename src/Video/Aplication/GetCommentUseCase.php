<?php
declare(strict_types=1);

namespace Symfony\Base\Video\Aplication;

use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Video\Domain\CommentFinder;

class GetCommentUseCase
{
    public function __construct(
        private readonly CommentFinder $finder
    )
    {
    }

    public function __invoke(string $id): CommentResponse
    {
        $comment = $this->finder->__invoke(new Uuid($id));

        return new CommentResponse(
            $comment->id()->value(),
            $comment->videoId()->value(),
            $comment->message()->value()
        );
    }
}