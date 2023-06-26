<?php

namespace Symfony\Base\Video\Aplication;

use Symfony\Base\Shared\Domain\Bus\Command\CommandHandler;
use Symfony\Base\Shared\Domain\Bus\Event\EventBus;
use Symfony\Base\Shared\Domain\Exception\InvalidValueException;
use Symfony\Base\Shared\Domain\ValueObject\Description;
use Symfony\Base\Shared\Domain\ValueObject\Name;
use Symfony\Base\Shared\Domain\ValueObject\Url;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Video\Domain\Exceptions\VideoNotFoundException;
use Symfony\Base\Video\Domain\Video;
use Symfony\Base\Video\Domain\VideoFinder;
use Symfony\Base\Video\Domain\VideoRepository;

class UpsertVideoCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly VideoRepository $videoRepository,
        private readonly VideoFinder $videoFinder,
        private readonly EventBus $bus
    )
    {
    }

    /**
     * @throws InvalidValueException
     */
    public function __invoke(UpsertVideoCommand $command): void
    {
        try {
            $this->videoFinder->__invoke(new Uuid($command->uuid()));
            $video = new Video(
                new Uuid($command->uuid()),
                new Uuid($command->userUuid()),
                new Name($command->name()),
                new Description($command->description()),
                new Url($command->url())
            );
        } catch (VideoNotFoundException) {
            $video = Video::create(
                new Uuid($command->uuid()),
                new Uuid($command->userUuid()),
                new Name($command->name()),
                new Description($command->description()),
                new Url($command->url())
            );
        }
        $this->videoRepository->save($video);
        $this->bus->publish(...$video->pullDomainEvents());
    }
}