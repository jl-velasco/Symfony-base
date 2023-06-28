<?php

namespace Symfony\Base\VideoProyection\Domain;

use Symfony\Base\Shared\Domain\AggregateRoot;
use Symfony\Base\Shared\Domain\ValueObject\Name;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\User\Domain\VideoCounter;
use Symfony\Base\Video\Domain\Comments;

final class VideoProyection extends AggregateRoot
{
    public function __construct(
        private readonly Uuid $id,
        private readonly Name $name,
        private ?Comments $comments =  new Comments([])
    ) {
    }
}