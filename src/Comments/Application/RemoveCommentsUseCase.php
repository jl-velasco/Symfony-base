<?php
declare(strict_types=1);

namespace Symfony\Base\Comments\Application;


use Symfony\Base\Shared\ValueObject\Uuid;
use Symfony\Base\Comments\Dominio\CommentsRepositoryInterface;

class RemoveCommentsUseCase
{
    public function __construct(private readonly CommentsRepositoryInterface $repository)
    {
    }

    public function __invoke(
        Uuid $id,
        bool $flush
    ): void
    {
        $this->repository->delete($id, $flush);
    }


}
