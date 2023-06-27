<?php

declare(strict_types=1);

namespace Symfony\Base\Video\Studio\Application;

use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Video\Studio\Domain\CommentMessage;
use Symfony\Base\Video\Studio\Domain\Exceptions\VideoNotFoundException;
use Symfony\Base\Video\Studio\Domain\VideoFinder;
use Symfony\Base\Video\Studio\Domain\VideoRepository;

final class InsertCommentUseCase
{
    public function __construct(private readonly VideoFinder $videoFinder, private readonly VideoRepository $videoRepository)
    {
    }

    /**
     * @throws VideoNotFoundException
     */
    public function __invoke(string $id, string $videoId, string $message): void
    {
        $video = $this->videoFinder->__invoke(new Uuid($videoId));
        $video->addComment(new Uuid($id), new CommentMessage($message));
        $this->videoRepository->save($video);
    }

}