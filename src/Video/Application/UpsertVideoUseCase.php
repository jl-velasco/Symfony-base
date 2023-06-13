<?php
declare(strict_types=1);

namespace Symfony\Base\Video\Application;

use Symfony\Base\Shared\Domain\Exceptions\InvalidValueException;
use Symfony\Base\Shared\ValueObject\CreatedAt;
use Symfony\Base\Shared\ValueObject\Description;
use Symfony\Base\Shared\ValueObject\Name;
use Symfony\Base\Shared\ValueObject\UpdatedAt;
use Symfony\Base\Shared\ValueObject\Url;
use Symfony\Base\Shared\ValueObject\Uuid;
use Symfony\Base\Video\Domain\Video;
use Symfony\Base\Video\Domain\VideoRepository;

class UpsertVideoUseCase
{
    public function __construct(
        private readonly VideoRepository $repository
    )
    {
    }

    /**
     * @throws InvalidValueException
     */
    public function __invoke(
        string $id,
        string $userId,
        string $name,
        string $description,
        string $url,
        string $createdAt = '',
        string $updatedAt = '',
    ): array
    {
        return $this->repository->save(
            new Video(
                new Uuid($id),
                new Uuid($userId),
                new Name($name),
                new Description($description),
                new Url($url),
                CreatedAt::fromPrimitive($createdAt),
                UpdatedAt::fromPrimitive($createdAt),
            )
        )->toPrimitives();
    }


}
