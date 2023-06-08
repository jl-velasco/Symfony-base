<?php

namespace Symfony\Base\Video\Aplication;

use Symfony\Base\Shared\ValueObject\Date;
use Symfony\Base\Shared\ValueObject\Uuid;
use Symfony\Base\Video\Domain\Video;
use Symfony\Base\Video\Domain\VideoDescription;
use Symfony\Base\Video\Domain\VideoName;
use Symfony\Base\Video\Domain\VideoRepository;
use Symfony\Base\Video\Domain\VideoUrl;

class UpsertVideoUseCase
{
    public function __construct(
        private readonly VideoRepository $videoRepository
    )
    {
    }

    public function __invoke(
        string $id,
        string $user_id,
        string $name,
        string $description,
        string $url,
        string $created_at,
        string $updated_at
    ): void
    {
        $this->videoRepository->save(
            new Video(
                new Uuid($id),
                new Uuid($user_id),
                new VideoName($name),
                new VideoDescription($description),
                new VideoUrl($url),
                new Date($created_at),
                new Date($updated_at)
            )
        );
    }

}