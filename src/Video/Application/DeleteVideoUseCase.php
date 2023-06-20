<?php

namespace Symfony\Base\Video\Application;

use Symfony\Base\Shared\Domain\Bus\Event\EventBus;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Video\Domain\VideoFinder;
use Symfony\Base\Video\Domain\VideoRepository;

class DeleteVideoUseCase
{
    public function __construct(
        private readonly VideoRepository $mySqlVideoRepository,
        private readonly VideoFinder $finder,
        private readonly EventBus $bus
    )
    {
    }

    public function __invoke(
        string $uuid
    ): void
    {
        $video = $this->finder->__invoke(new Uuid($uuid));
        $video->delete();
        $this->mySqlVideoRepository->delete($video->uuid());
        $this->bus->publish(...$video->pullDomainEvents());
    }
}
