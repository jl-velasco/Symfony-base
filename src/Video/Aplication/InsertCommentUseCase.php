<?php

declare(strict_types=1);

namespace Symfony\Base\Video\Aplication;

use Symfony\Base\Shared\Domain\ValueObject\Video;
use Symfony\Base\Video\Domain\CommentMessage;
use Symfony\Base\Video\Domain\Exceptions\VideoNotFoundException;
use Symfony\Base\Video\Domain\VideoFinder;
use Symfony\Base\Video\Domain\VideoRepository;

final class InsertCommentUseCase
{
    public function __construct(private readonly VideoFinder $videoFinder, private readonly VideoRepository $repository)
    {
    }

    /**
     * @throws VideoNotFoundException
     */
    public function __invoke(string $id, string $videoId, string $message): void
    {
        $video = $this->videoFinder->__invoke(new Video($videoId));
        $video->addComment(new Video($id), new CommentMessage($message));
        $this->repository->save($video);
    }

}
