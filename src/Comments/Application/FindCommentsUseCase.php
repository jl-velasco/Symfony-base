<?php
declare(strict_types=1);

namespace Symfony\Base\Comments\Application;


use Symfony\Base\Comments\Dominio\Comments;
use Symfony\Base\Shared\ValueObject\Uuid;
use Symfony\Base\Comments\Dominio\CommentsRepository;

class FindCommentsUseCase
{
    public function __construct(private readonly CommentsRepository $repository)
    {
    }

    public function __invoke(Uuid $id): ?Comments
    {
        return $this->repository->search($id);
    }


}
