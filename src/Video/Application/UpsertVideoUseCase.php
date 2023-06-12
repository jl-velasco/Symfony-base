<?php
declare(strict_types=1);

namespace Symfony\Base\Video\Application;

use Symfony\Base\Shared\ValueObject\Date;
use Symfony\Base\Shared\ValueObject\Name;
use Symfony\Base\Shared\ValueObject\Url;
use Symfony\Base\Shared\ValueObject\Uuid;
use Symfony\Base\Video\Domain\Video;
use Symfony\Base\Video\Domain\VideoDescription;
use Symfony\Base\Video\Domain\VideoRepository;

class UpsertVideoUseCase
{
    public function __construct(
        private readonly VideoRepository $repository
    )
    {
    }

    public function __invoke(
        string $id,
        string $userId,
        string $name,
        string $description,
        string $url
    ): void
    {
        $this->repository->save(
            new Video(
                new Uuid($id),
                new Uuid($userId),
                new Name($name),
                new VideoDescription($description),
                new Url($url),
                new Date(),
                new Date()
            )
        );
    }

}