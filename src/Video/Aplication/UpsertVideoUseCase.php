<?php

namespace Symfony\Base\Video\Aplication;

use Symfony\Base\Shared\Domain\ValueObject\Description;
use Symfony\Base\Shared\Domain\ValueObject\Name;
use Symfony\Base\Shared\Domain\ValueObject\Url;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Video\Domain\Video;
use Symfony\Base\Video\Domain\VideoRepository;

class UpsertVideoUseCase
{
    public function __construct(
        private readonly VideoRepository $mySqlVideoRepository
    )
    {
    }

    /**
     * @throws InvalidValueException
     */
    public function __invoke(
        string $uuid,
        string $userUuid,
        string $name,
        string $description,
        string $url
    ): void
    {
        $this->mySqlVideoRepository->save(
            new Video(
                new Uuid($userUuid),
                new Uuid($uuid),
                new Name($name),
                new Description($description),
                new Url($url)
            )
        );
    }
}