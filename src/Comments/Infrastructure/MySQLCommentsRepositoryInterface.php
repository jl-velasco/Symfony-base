<?php
declare(strict_types=1);

namespace Symfony\Base\Comments\Infrastructure;

use Symfony\Base\Shared\ValueObject\Uuid;
use Symfony\Base\Comments\Dominio\Comments;
use Symfony\Base\Comments\Dominio\CommentsRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;


class MySQLCommentsRepositoryInterface implements CommentsRepositoryInterface
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function save(Comments $comments): void
    {
        $this->entityManager->persist($comments);
        $this->entityManager->flush();

    }

    public function search(Uuid $id): Comments
    {
        return $this->entityManager->getRepository(Comments::class)->findOneBy(['id' => $id]);
    }

    public function delete(Uuid $id, $flush): void
    {
        $this->entityManager->remove($this->entityManager->getRepository(Comments::class)->findOneBy(['id' => $id]));

        if ($flush) {
            $this->entityManager->flush();
        }
    }
}
