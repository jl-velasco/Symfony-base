<?php
declare(strict_types=1);

namespace Symfony\Base\Video\Infrastructure;

use Doctrine\DBAL\Connection;
use Symfony\Base\Shared\Infrastructure\Exceptions\SqlConnectionException;
use Symfony\Base\Shared\ValueObject\Uuid;
use Symfony\Base\Video\Domain\Exceptions\VideoNotFoundException;
use Symfony\Base\Video\Domain\Video;
use Symfony\Base\Video\Domain\VideoRepository;


class MySQLVideoRepository implements VideoRepository
{
    public const TABLE = 'video';

    public function __construct(
        private readonly Connection $connection
    )
    {
    }

    public function save(Video $video): Video
    {
        try {
            if (!is_null($entity = $this->search($video->id()))) {
                $this->connection->update(
                    self::TABLE,
                    $video->toPrimitives(),
                    [
                        'id' => $entity->id()->value()
                    ]
                );
            } else
                $this->connection->insert(
                    self::TABLE,
                    $video->toPrimitives(),
                );
        }
        catch (\Exception $e) {
            throw new SqlConnectionException($e);
        }

        return $this->search($video->id());
    }

    public function search(Uuid $id): Video|null
    {
        try {
            $result = $this->connection->createQueryBuilder()
                ->select('*')
                ->from(self::TABLE)
                ->where('id = :id')
                ->setParameter('id', $id->value())
                ->executeQuery()
                ->fetchAssociative();

            if (!$result)
                return null;

            return Video::fromPrimitives($result);
        } catch (\Exception $e) {
            throw new SqlConnectionException($e);
        }
    }

    public function delete(Uuid $id): void
    {
        try {
            $this->connection->delete(
                self::TABLE,
                [
                    'id' => $id->value()
                ]
            );
        }
        catch (\Exception $e) {
            throw new SqlConnectionException($e);
        }
    }
}
