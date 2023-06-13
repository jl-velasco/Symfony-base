<?php
declare(strict_types=1);

namespace Symfony\Base\Video\Aplication;

use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Video\Domain\Exceptions\VideoNotExistException;
use Symfony\Base\Video\Domain\VideoFinder;
use Symfony\Base\Video\Domain\VideoRepository;

class GetVideoUseCase
{
    public function __construct(
        private readonly VideoFinder $finder
    )
    {

    }

    public function __invoke(string $id): VideoResponse
    {
        // el servicio
        $Video = $this->finder->__invoke(new Uuid($id));

        return new VideoResponse(
            $Video->uuid()->value(),
            $Video->userUuid()->value(),
            $Video->name()->value(),
            $Video->description()->value(),
            $Video->url()->value(),
            $Video->createdAt()?->stringDateTime()
        );
    }
}