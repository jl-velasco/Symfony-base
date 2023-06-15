<?php
declare(strict_types=1);

namespace Symfony\Base\Video\Aplication;

use Symfony\Base\Shared\Domain\Bus\Event\EventBus;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Video\Domain\Exceptions\VideoNotFoundException;
use Symfony\Base\Video\Domain\VideoFinder;
use Symfony\Base\Video\Domain\VideoRepository;

class DeleteVideo
{
    public function __construct(
        private readonly VideoRepository $repository,
        private readonly VideoFinder $finder,
        private readonly EventBus $bus
    )
    {
    }

    /**
     * @throws VideoNotFoundException
     */
    public function __invoke(string $id): void
    {
        $video = $this->finder->__invoke(new Uuid($id));
        $video->delete();
        $this->repository->delete(new Uuid($id));
        $this->bus->publish(...$video->pullDomainEvents());
    }
}