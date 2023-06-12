<?php

declare(strict_types=1);

namespace Symfony\Base\Video\Infrastructure;

use Symfony\Base\Shared\ValueObject\Uuid;
use Symfony\Base\Video\Dominio\Video;
use Symfony\Base\Video\Dominio\VideoRepository;

class MySQLVideoRepository implements VideoRepository
{

    public function __construct(private readonly Connection $connection)
    {
    }

    public function save(Video $Video): void
    {
        $query = $this->connection->prepare(
            'INSERT INTO videos VALUES (:id, :userid, :name, :description, :url, :created_at)
            ON DUPLICATE KEY UPDATE userid = :userid, name = :name, description = :description, url = :url, updated_at = :updated_at'
        );
        $query->bindValue('id', $video->id());
        $query->bindValue('userid', $video->userId());
        $query->bindValue('name', $video->name());
        $query->bindValue('description', $video->description());
        $query->bindValue('url', $video->url());
        $query->bindValue('created_at', $video->createdAt());
        $query->bindValue('updated_at', $video->updatedAt() ?: 'NOW()');
        $query->executeQuery();
    }

    public function search(Uuid $id): Video
    {
        $query = $this->connection->prepare('SELECT * FROM videos WHERE id = :id');
        $query->bindValue('id', $id);
        $result = $query->executeQuery();
        $row = $result->fetchAssociative();

        return new Video(
            $row['id'],
            $row['userid'],
            $row['name'],
            $row['description'],
            $row['url'],
            $row['created_at'],
            $row['updated_at'],
        );
    }

    public function delete(Uuid $id): void
    {
        $query = $this->connection->prepare('DELETE FROM videos WHERE id = :id');
        $query->bindValue('id', $id);
        $result = $query->executeQuery();
    }
}
