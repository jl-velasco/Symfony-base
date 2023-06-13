<?php
declare(strict_types=1);

namespace Symfony\Base\Video\Application;

use Symfony\Base\Shared\Domain\Exceptions\InvalidValueException;
use Symfony\Base\Shared\Domain\ValueObject\CreatedAt;
use Symfony\Base\Shared\Domain\ValueObject\Name;
use Symfony\Base\Shared\Domain\ValueObject\UpdatedAt;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Shared\Domain\ValueObject\Description;
use Symfony\Base\Shared\Domain\ValueObject\Url;
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
     * @throws \Symfony\Base\Shared\Domain\Exception\InvalidValueException
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
