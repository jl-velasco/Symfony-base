<?php
declare(strict_types=1);

namespace Symfony\Base\Video\Application;

use Symfony\Base\Shared\ValueObject\CreatedAt;
use Symfony\Base\Shared\ValueObject\Name;
use Symfony\Base\Shared\ValueObject\UpdatedAt;
use Symfony\Base\Shared\ValueObject\Url;
use Symfony\Base\Shared\ValueObject\Uuid;
use Symfony\Base\Video\Dominio\Description;
use Symfony\Base\Video\Dominio\Video;
use Symfony\Base\Video\Dominio\VideoRepositoryInterface;

class UpsertVideoUseCase
{
    public function __construct(private readonly VideoRepositoryInterface $repository)
    {
    }

    public function __invoke(
        string $id,
        string $userId,
        string $name,
        string $description,
        string $url,
        string $updatedAt,
        string $createdAt,
    ): void
    {
        $this->repository->save(
            new Video(
                new Uuid($id),
                new Uuid($userId),
                new Name($name),
                new Description($description),
                new Url($url),
                new UpdatedAt($updatedAt),
                new CreatedAt($createdAt)
            )
        );
    }


}
