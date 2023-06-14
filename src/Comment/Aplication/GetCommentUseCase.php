<?php
declare(strict_types=1);

namespace Symfony\Base\Comment\Aplication;

use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Comment\Domain\Exceptions\CommentNotExistException;
use Symfony\Base\Comment\Domain\CommentFinder;
use Symfony\Base\Comment\Domain\CommentRepository;

class GetCommentUseCase
{
    public function __construct(
        // private readonly CommentFinder $finder
    )
    {

    }

    public function __invoke(string $id): CommentResponse
    {
        /*
        return new CommentResponse(
            $Comment->uuid()->value(),
            $Comment->videoUuid()->value(),
            $Comment->name()->value(),
            $Comment->description()->value(),
            $Comment->createdAt()?->stringDateTime()
        );*/
    }
}