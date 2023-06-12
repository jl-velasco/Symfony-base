<?php
declare(strict_types=1);
namespace Symfony\Base\Video\Aplication;

use Symfony\Base\Shared\ValueObject\Description;
use Symfony\Base\Shared\ValueObject\Name;
use Symfony\Base\Shared\ValueObject\URL;
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

    public function __invoke(
        string $id,
        string $video_user_id,
        string $name,
        string $description,
        string $url
    ):void
    {
        $this->repository->save(
            new Video(
                new Uuid($id),
                new Uuid($video_user_id),
                new Name($name),
                new Description($description),
                new URL($url)
            )
        );
    }
}