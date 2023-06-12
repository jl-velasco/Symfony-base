<?php

namespace Symfony\Base\Video\Aplication;

use Symfony\Base\Shared\ValueObject\Date;
use Symfony\Base\Shared\ValueObject\Description;
use Symfony\Base\Shared\ValueObject\Name;
use Symfony\Base\Shared\ValueObject\Url;
use Symfony\Base\Shared\ValueObject\Uuid;
use Symfony\Base\Video\Dominio\Video;
use Symfony\Base\Video\Dominio\VideoRepository;

class UpsetVideoUseCase
{
    public function __construct(
        private readonly VideoRepository $repository)
    {
    }

    public function __invoke(string $video_id,
                             string $video_user_id,
                             string $name,
                             string $description,
                             string $url,
                             string $created_at,
                             string $updated_at
    ): void
    {
        $this->repository->save(
            new Video(
                new Uuid($video_id),
                new Uuid($video_user_id),
                new Name($name),
                new Description($description),
                new Url($url),
                new Date(),
                new Date(),


            )
        );
    }


}
