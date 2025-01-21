<?php

namespace Symfony\Base\Coche\Infrastructure;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Base\Coche\Domain\Coche;
use Symfony\Base\Coche\Domain\CocheId;

class DoctrinelCocheRepository
{
    public function __construct(
        private EntityManagerInterface $entityManager
    )
    {
    }

    public function findById(CocheId $id): ?Coche
    {
        return $this->entityManager->find(Coche::class, $id);
    }

    public function save(Coche $coche): void
    {
        $this->entityManager->persist($coche);
        $this->entityManager->flush();
    }

    public function delete(CocheId $id): void
    {
        $coche = $this->entityManager->find(Coche::class, $id);
        $this->entityManager->remove($coche);
        $this->entityManager->flush();
    }

    public function update(Coche $coche): void
    {
        $this->entityManager->persist($coche);
        $this->entityManager->flush();
    }
}