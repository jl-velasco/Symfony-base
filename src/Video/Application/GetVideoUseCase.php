<?php
declare(strict_types=1);

namespace Symfony\Base\Video\Application;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;

class GetVideoUseCase
{
    public function __construct(
        private readonly VideoFinder $finder
    )
    {
    }

    public function __invoke(string $id): VideoResponse
    {
        $video = $this->finder->__invoke(new Uuid($id));
        return new VideoResponse($video->toPrimitives());
    }
}
