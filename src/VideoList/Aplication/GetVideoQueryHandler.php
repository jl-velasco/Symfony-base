<?php

declare(strict_types=1);

namespace Symfony\Base\VideoList\Aplication;


use Symfony\Base\Shared\Domain\Bus\Query\QueryHandler;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\VideoList\Domain\Exceptions\VideoNotFoundException;
use Symfony\Base\VideoList\Domain\VideoFinder;

final class GetVideoQueryHandler implements QueryHandler
{
    public function __construct(private readonly VideoFinder $finder)
    {
    }

    /**
     * @throws VideoNotFoundException
     */
    public function __invoke(GetCommentQuery $query): VideoResponse
    {
        $video = $this->finder->__invoke(new Uuid($query->id()));

        return new VideoResponse(
            $video->id()->value(),
            $video->userId()->value(),
            $video->name()->value(),
            $video->description()->value(),
            $video->url()->value()
        );
    }
}