<?php
declare(strict_types=1);

namespace Symfony\Base\Video\Aplication;

use Symfony\Base\Shared\Domain\Bus\Event\EventBus;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Video\Domain\VideoFinder;
use Symfony\Base\Video\Domain\VideoRepository;

class DeleteVideoUseCase
{
    public function __construct(
        private readonly VideoRepository $repository,
        private readonly VideoFinder $finder,
        private readonly EventBus $bus
    )
    {
    }

    public function __invoke(string $id): void
    {
        $Video = $this->finder->__invoke(new Uuid($id));
        $Video->delete();
        $this->repository->delete(new Uuid($id));
        $this->bus->publish(...$Video->pullDomainEvents());
    }
}