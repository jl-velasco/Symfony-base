<?php

declare(strict_types=1);

namespace Symfony\Base\Comment\Aplication;

use Symfony\Base\Comment\Domain\CommentFinder;
use Symfony\Base\Comment\Domain\Exceptions\CommentNotFoundException;
use Symfony\Base\Shared\Domain\Bus\Query\QueryHandler;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;

final class GetCommentQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly CommentFinder $finder
    )
    {
    }

    /**
     * @throws CommentNotFoundException
     */
    public function __invoke(GetCommentQuery $query): CommentResponse
    {
        $comment = $this->finder->__invoke(new Uuid($query->id()));

        return new CommentResponse(
            $comment->id()->value(),
            $comment->videoId()->value(),
            $comment->message()->value(),
            $comment->userId()->value()
        );
    }
}