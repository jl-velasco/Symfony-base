<?php
declare(strict_types=1);

namespace Symfony\Base\Video\Aplication;

use Symfony\Base\Shared\Domain\Bus\Event\EventBus;
use Symfony\Base\Shared\Domain\ValueObject\Description;
use Symfony\Base\Shared\Domain\ValueObject\Name;
use Symfony\Base\Shared\Domain\ValueObject\Url;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Video\Domain\Video;
use Symfony\Base\Video\Domain\VideoRepository;

class InsertVideoUseCase
{
    public function __construct(
        private readonly VideoRepository $repository,
        private readonly EventBus $bus
    )
    {
    }

    public function __invoke(        string $uuid,
                                     string $userUuid,
                                     string $name,
                                     string $description,
                                     string $url): void
    {

        $Video =  new Video(
            new Uuid($uuid),
            new Uuid($userUuid),
            new Name($name),
            new Description($description),
            new Url($url)
        );
        // insertamos el video
        $this->repository->save($Video);
        // mandamos el evento
        $Video->insert();
        $this->bus->publish(...$Video->pullDomainEvents());
    }
}