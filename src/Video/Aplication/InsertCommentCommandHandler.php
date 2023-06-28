<?php

declare(strict_types=1);

namespace Symfony\Base\Video\Aplication;

use Symfony\Base\Shared\Domain\Bus\Command\CommandHandler;
use Symfony\Base\Shared\Domain\Bus\Event\EventBus;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Video\Domain\CommentMessage;
use Symfony\Base\Video\Domain\Exceptions\VideoNotFoundException;
use Symfony\Base\Video\Domain\VideoFinder;
use Symfony\Base\Video\Domain\VideoRepository;

final class InsertCommentCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly VideoFinder $videoFinder,
        private readonly VideoRepository $videoRepository,
        private readonly EventBus $bus
    )
    {
    }

    /**
     * @throws VideoNotFoundException
     */
    public function __invoke(InsertCommentCommand $command): void
    {
        $video = $this->videoFinder->__invoke(new Uuid($command->videoId()));
        $video->addComment(new Uuid($command->id()), new CommentMessage($command->message()), new Uuid($command->userId()));
        $this->videoRepository->save($video);
        $this->bus->publish(...$video->pullDomainEvents());
    }

}