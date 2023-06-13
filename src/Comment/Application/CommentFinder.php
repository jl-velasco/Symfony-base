<?php

declare(strict_types = 1);

namespace Symfony\Base\Comment\Application;

use Symfony\Base\Comment\Domain\CommentRepository;
use Symfony\Base\Comment\Domain\Exceptions\CommentNotFoundException;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Video\Domain\Video;


final class CommentFinder
{
    public function __construct(private readonly CommentRepository $repository)
    {
    }

    public function __invoke(Uuid $id): Video
    {
        $video = $this->repository->search($id);

        if ($video === null) {
            throw new CommentNotFoundException((string) $id);
        }

        return $video;
    }
}
