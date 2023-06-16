<?php
declare(strict_types=1);

namespace Symfony\Base\Video\Aplication;

use Symfony\Base\Shared\Domain\Bus\Event\EventBus;
use Symfony\Base\Shared\Domain\ValueObject\StringValueObject;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\User\Domain\User;
use Symfony\Base\User\Domain\UserFinder;
use Symfony\Base\User\Domain\UserRepository;
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

    public function __invoke(string $id, string $videoId): void
    {

        // obtenemos todos los videos
        //$Videos = $this->repository->findByUserUuid(new Uuid($id));

        $Video = $this->finder->__invoke(new Uuid($videoId));
        // esto es el evento
        $Video->delete();

        // borramos el video
        $this->repository->delete(new Uuid($videoId));

        // FUNCIONA PARA ELIMINAR VIDEOS DE UN USUARIO Y EL USUARIO
        //$this->repository->deleteByUserId(new Uuid($id));
        //$this->userRepository->delete(new Uuid($id));

        $this->bus->publish(...$Video->pullDomainEvents());
    }
}