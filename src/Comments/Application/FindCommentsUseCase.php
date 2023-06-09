<?php
declare(strict_types=1);

namespace Symfony\Base\Comments\Application;


use Symfony\Base\Shared\ValueObject\Uuid;
use Symfony\Base\Comments\Dominio\CommentsRepositoryInterface;

class FindCommentsUseCase
{
    public function __construct(private readonly CommentsRepositoryInterface $repository)
    {
    }

    public function __invoke(
        Uuid $id,
    ): void
    {
        $this->repository->search($id);
    }


}
