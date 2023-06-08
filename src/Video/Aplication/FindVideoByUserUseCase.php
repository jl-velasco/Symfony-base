<?php
declare(strict_types=1);

namespace Symfony\Base\Video\Aplication;

use Symfony\Base\Shared\ValueObject\Uuid;
use Symfony\Base\Video\Domain\VideoRepository;

class FindVideoByUserUseCase
{
    public function __construct(
        private readonly VideoRepository $repository
    )
    {
    }

    public function __invoke(
        string $id
    ): void
    {
        $this->repository->searchByUserId(
            new Uuid($id)
        );
    }


}