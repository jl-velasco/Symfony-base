<?php
declare(strict_types=1);

namespace Symfony\Base\Video\Infrastructure;

use Symfony\Base\Shared\ValueObject\Uuid;
use Symfony\Base\Video\Dominio\Video;
use Symfony\Base\Video\Dominio\VideoRepository;
use Doctrine\ORM\EntityManagerInterface;


class MySQLVideoRepository implements VideoRepository
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function save(Video $video): void
    {
        $this->entityManager->persist($video);
        $this->entityManager->flush();

    }

    public function search(Uuid $id): Video
    {
        return $this->entityManager->getRepository(Video::class)->findOneBy(['id' => $id]);
    }

    public function delete(Uuid $id, $flush): void
    {
        $this->entityManager->remove($this->entityManager->getRepository(Video::class)->findOneBy(['id' => $id]));

        if ($flush) {
            $this->entityManager->flush();
        }
    }
}
