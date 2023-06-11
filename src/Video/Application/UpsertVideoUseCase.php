<?php
declare(strict_types=1);


namespace Symfony\Base\User\Aplication;




use Symfony\Base\Shared\Exception\InvalidValueException;
use Symfony\Base\Shared\ValueObject\CreatedAt;
use Symfony\Base\Shared\ValueObject\Date;
use Symfony\Base\Shared\ValueObject\UpdatedAt;
use Symfony\Base\Shared\ValueObject\VideoDescription;
use Symfony\Base\Shared\ValueObject\VideoUrl;
use Symfony\Base\Shared\ValueObject\Uuid;
use Symfony\Base\Shared\ValueObject\VideoName;
use Symfony\Base\Video\Dominio\Video;
use Symfony\Base\Video\Dominio\VideoRepository;

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
        string $created_at,
        string $updated_at
    ):void{
        $this->repository->save(
            new Video(
                new Uuid($id),
                new Uuid($userId),
                new VideoName($name),
                new VideoDescription($description),
                new VideoUrl($url),
                new CreatedAt($created_at),
                new UpdatedAt($updated_at)
            )
        );
    }
}
