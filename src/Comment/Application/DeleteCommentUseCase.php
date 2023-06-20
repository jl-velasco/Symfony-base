<?php
declare(strict_types=1);

namespace Symfony\Base\Comment\Application;

use Symfony\Base\Comment\Domain\CommentFinder;
use Symfony\Base\Comment\Domain\CommentRepository;
use Symfony\Base\Shared\Domain\Exceptions\InvalidValueException;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;

class DeleteCommentUseCase
{
    public function __construct(
        private readonly CommentFinder $finder,
        private readonly CommentRepository $repository,
    )
    {
    }

    /**
     * @throws InvalidValueException
     */
    public function __invoke(
        string $id,
    ): void
    {
        $comment = $this->finder->__invoke(new Uuid($id));
        $this->repository->delete(
            new Uuid($id)
        );
    }


}
