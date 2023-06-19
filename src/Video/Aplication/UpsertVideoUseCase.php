<?php

namespace Symfony\Base\Video\Aplication;

use Symfony\Base\Shared\Domain\Bus\Event\EventBus;
use Symfony\Base\Shared\Domain\ValueObject\Description;
use Symfony\Base\Shared\Domain\ValueObject\Name;
use Symfony\Base\Shared\Domain\ValueObject\Url;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Video\Domain\Exceptions\VideoNotFoundException;
use Symfony\Base\Video\Domain\Video;
use Symfony\Base\Video\Domain\VideoFinder;
use Symfony\Base\Video\Domain\VideoRepository;

class UpsertVideoUseCase
{
    public function __construct(
        private readonly VideoRepository $mySqlVideoRepository,
        private readonly VideoFinder $finder,
        private readonly EventBus $bus
    )
    {
    }

    public function __invoke(
        string $uuid,
        string $userUuid,
        string $name,
        string $description,
        string $url
    ): void
    {
        try {
            $video = $this->finder->__invoke(new Uuid($uuid));
            $video = new Video(
                new Uuid($uuid),
                new Uuid($userUuid),
                new Name($name),
                new Description($description),
                new Url($url)
            );

            $this->mySqlVideoRepository->save($video);
        } catch (VideoNotFoundException $e) {
            $video = new Video(
                new Uuid($uuid),
                new Uuid($userUuid),
                new Name($name),
                new Description($description),
                new Url($url)
            );

            $video->save();
            $this->mySqlVideoRepository->save($video);
            $this->bus->publish(...$video->pullDomainEvents());
        }
    }
}