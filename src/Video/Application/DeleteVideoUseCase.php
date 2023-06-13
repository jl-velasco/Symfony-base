<?php
declare(strict_types=1);

namespace Symfony\Base\Video\Application;

use Symfony\Base\Comment\Domain\CommentRepository;
use Symfony\Base\Shared\Domain\Exceptions\InvalidValueException;
use Symfony\Base\Shared\ValueObject\CreatedAt;
use Symfony\Base\Shared\ValueObject\Description;
use Symfony\Base\Shared\ValueObject\Name;
use Symfony\Base\Shared\ValueObject\UpdatedAt;
use Symfony\Base\Shared\ValueObject\Url;
use Symfony\Base\Shared\ValueObject\Uuid;
use Symfony\Base\Video\Application\Exceptions\VideoHaveCommentsException;
use Symfony\Base\Video\Domain\Exceptions\VideoNotFoundException;
use Symfony\Base\Video\Domain\Video;
use Symfony\Base\Video\Domain\VideoRepository;

class DeleteVideoUseCase
{
    public function __construct(
        private readonly VideoRepository $repository,
        private readonly CommentRepository $comments
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
        $video = $this->repository->search(
            new Uuid($id)
        );

        if (is_null($video))
            throw new VideoNotFoundException(sprintf('Video not found. ID: %s',$id));

        $comments = $this->comments->getByVideo(new Uuid($id));
        if (count($comments) > 0)
            throw new VideoHaveCommentsException(sprintf('Cannot delete the video because it has comments. ID: %s',$id));

        $this->repository->delete(
            new Uuid($id)
        );
    }


}
