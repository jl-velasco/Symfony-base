<?php
declare(strict_types=1);

namespace Symfony\Base\Comment\Application;

use Symfony\Base\Shared\Domain\Exceptions\InvalidValueException;
use Symfony\Base\Shared\ValueObject\CreatedAt;
use Symfony\Base\Shared\ValueObject\Description;
use Symfony\Base\Shared\ValueObject\UpdatedAt;
use Symfony\Base\Shared\ValueObject\Uuid;
use Symfony\Base\Comment\Domain\Comment;
use Symfony\Base\Comment\Domain\CommentRepository;

class GetListCommentUseCase
{
    public function __construct(
        private readonly CommentRepository $repository
    )
    {
    }

    /**
     * @throws InvalidValueException
     */
    public function __invoke(
        string $videoId
    ): array
    {
        $comments = $this->repository->getByVideo(
            new Uuid($videoId)
        );
        $result = [];
        foreach($comments as $comment)
            $result[] = $comment->toPrimitives();
        return $result;
    }


}
