<?php

namespace Symfony\Base\Video\Application;

use Symfony\Base\Shared\Domain\Bus\Event\EventBus;
use Symfony\Base\Shared\Domain\Exceptions\InvalidValueException;
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
        private readonly EventBus $bus,
    )
    {
    }

    /**
     * @throws InvalidValueException
     * @throws InvalidValueException
     * @throws \Symfony\Base\Shared\Domain\Exception\InvalidValueException
     */
    public function __invoke(
        string $id,
        string $userUuid,
        string $name,
        string $description,
        string $url
    ): void
    {
        $pushEvent = false;
        try {
            $this->finder->__invoke(new Uuid($id));
        } catch (VideoNotFoundException) {
            $pushEvent = true;
        }
        $this->mySqlVideoRepository->save(
            new Video(
                new Uuid($id),
                new Uuid($userUuid),
                new Name($name),
                new Description($description),
                new Url($url)
            )
        );

        if ($pushEvent){
            $video = $this->finder->__invoke(new Uuid($id));
            $video->add();
            $this->bus->publish(...$video->pullDomainEvents());
        }
    }
}
