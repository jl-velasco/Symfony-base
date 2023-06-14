<?php
declare(strict_types=1);

namespace Symfony\Base\Video\Application;

use Symfony\Base\Comment\Domain\CommentRepository;
use Symfony\Base\Shared\Domain\Bus\Event\EventBus;
use Symfony\Base\Shared\Domain\Exceptions\InvalidValueException;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Video\Application\Exceptions\VideoHaveCommentsException;
use Symfony\Base\Video\Domain\Exceptions\VideoNotFoundException;
use Symfony\Base\Video\Domain\VideoFinder;
use Symfony\Base\Video\Domain\VideoRepository;

class DeleteVideoUseCase
{
    public function __construct(
        private readonly VideoRepository $repository,
        private readonly CommentRepository $comments,
        private readonly VideoFinder $finder,
        private readonly EventBus $bus,
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
        $video = $this->finder->__invoke(new Uuid($id));

        $comments = $this->comments->getByVideo(new Uuid($id));
        if (count($comments) > 0)
            throw new VideoHaveCommentsException(sprintf('Cannot delete the video because it has comments. ID: %s',$id));

        $video->delete();

        $this->repository->delete(
            new Uuid($id)
        );

        $this->bus->publish(...$video->pullDomainEvents());
    }


}
