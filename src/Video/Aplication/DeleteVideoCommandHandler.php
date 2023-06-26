<?php

namespace Symfony\Base\Video\Aplication;

use Symfony\Base\Shared\Domain\Bus\Command\CommandHandler;
use Symfony\Base\Shared\Domain\Bus\Event\EventBus;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Video\Domain\Exceptions\VideoNotFoundException;
use Symfony\Base\Video\Domain\VideoFinder;
use Symfony\Base\Video\Domain\VideoRepository;

class DeleteVideoCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly VideoRepository $videoRepository,
        private readonly VideoFinder $finder,
        private readonly EventBus $bus
    ) {
    }

    /**
     * @throws VideoNotFoundException
     */
    public function __invoke(string $uuid): void
    {
        $video = $this->finder->__invoke(new Uuid($uuid));
        $video->delete();

        $this->videoRepository->delete($video->uuid());
        $this->bus->publish(...$video->pullDomainEvents());
    }
}