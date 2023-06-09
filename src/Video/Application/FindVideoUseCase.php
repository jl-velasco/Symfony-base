<?php
declare(strict_types=1);

namespace Symfony\Base\Video\Application;


use Symfony\Base\Shared\ValueObject\Uuid;
use Symfony\Base\Video\Dominio\VideoRepositoryInterface;

class FindVideoUseCase
{
    public function __construct(private readonly VideoRepositoryInterface $repository)
    {
    }

    public function __invoke(
        Uuid $id,
    ): void
    {
        $this->repository->search($id);
    }


}
