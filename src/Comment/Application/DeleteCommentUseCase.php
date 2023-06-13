<?php
declare(strict_types=1);

namespace Symfony\Base\Comment\Application;

use Symfony\Base\Comment\Domain\CommentRepository;
use Symfony\Base\Shared\Domain\Exceptions\InvalidValueException;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Video\Application\Exceptions\VideoHaveCommentsException;
use Symfony\Base\Video\Domain\Exceptions\VideoNotFoundException;
use Symfony\Base\Video\Domain\VideoRepository;

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
        $video = $this->finder(
            new Uuid($id)
        );

        $this->repository->delete(
            new Uuid($id)
        );
    }


}
