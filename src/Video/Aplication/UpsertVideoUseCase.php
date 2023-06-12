<?php

declare(strict_types=1);

namespace Symfony\Base\Video\Aplication;

use Symfony\Base\Shared\ValueObject\Uuid;
use Symfony\Base\Video\Dominio\Video;
use Symfony\Base\Video\Dominio\VideoUrl;
use Symfony\Base\Video\Dominio\VideoName;
use Symfony\Base\Video\Dominio\VideoRepository;
use Symfony\Base\Video\Dominio\VideoDescription;

class UpsertVideoUseCase
{
    public function __construct(
        private readonly VideoRepository $repository
    ) {
    }

    public function __invoke(
        string $id,
        string $useId,
        string $name,
        string $description,
        string $url
    ): void {
        $this->repository->save(
            new Video(
                new Uuid($id),
                new Uuid($useId),
                new VideoName($name),
                new VideoDescription($description),
                new VideoUrl($url)
            )
        );
    }
}
