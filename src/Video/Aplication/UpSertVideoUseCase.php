<?php

namespace Symfony\Base\Video\Aplication;

use Symfony\Base\Shared\Exception\InvalidValueException;
use Symfony\Base\Shared\ValueObject\Date;
use Symfony\Base\Shared\ValueObject\Description;
use Symfony\Base\Shared\ValueObject\Name;
use Symfony\Base\Shared\ValueObject\Url;
use Symfony\Base\Shared\ValueObject\Uuid;
use Symfony\Base\Video\Domain\Video;
use Symfony\Base\Video\Domain\VideoRepository;

class UpSertVideoUseCase
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
                new Uuid($uuid),
                new Uuid($userUuid),
                new Name($name),
                new Description($description),
                new Url($url)
            )
        );
    }
}