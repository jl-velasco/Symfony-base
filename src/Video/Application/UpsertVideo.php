<?php

namespace Symfony\Base\Video\Application;

use Symfony\Base\Shared\Domain\Exception\InvalidValueException;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Video\Domain\Description;
use Symfony\Base\Video\Domain\Name;
use Symfony\Base\Video\Domain\Url;
use Symfony\Base\Video\Domain\User;
use Symfony\Base\Video\Domain\Video;
use Symfony\Base\Video\Domain\VideoRepository;

class UpsertVideo
{
    public function __construct(private readonly VideoRepository $repository)
    {
    }

    /**
     * @throws InvalidValueException
     */
    public function __invoke(
        string $id,
        string $name,
        string $description,
        string $url,
        string $user,
    ): void
    {
        $this->repository->save(new Video(
            new Uuid($id),
            new Name($name),
            new Description($description),
            new Url($url),
            new User(new Uuid($user)),
        ));
    }
}