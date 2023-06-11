<?php
declare(strict_types=1);

namespace Symfony\Base\Video\Infrastructure;

//use Doctrine\DBAL\Connection;
use Symfony\Base\Shared\ValueObject\Uuid;
use Symfony\Base\Video\Dominio\Video;
use Symfony\Base\Video\Dominio\VideoRepository;

class MySQLVideoRepository implements VideoRepository
{


    public function __construct(private readonly Connection $connection)
    {
    }

    public function save(Video $video): void
    {
        // TODO: ¿exceptions?, ¿error control?
        $stmt = $this->connection->prepare("INSERT INTO videos 
            VALUES (:id,:userid, :name,:description,:url,:created_at)");

        $stmt->bindValue('id', $video->id());
        $stmt->bindValue('userid', $video->userId());
        $stmt->bindValue('name', $video->name());
        $stmt->bindValue('description', $video->description());
        $stmt->bindValue('url', $video->url());
        $stmt->bindValue('created_at', $video->createdAt());
        $stmt->executeQuery();
    }

    public function search(Uuid $uuid): Video
    {
        $sql = "SELECT * FROM videos WHERE id = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(1, $uuid);
        $resultSet = $stmt->executeQuery();

        if (!$resultSet) {
            //@todo specific exception
            //throw new \RuntimeException();
        }

        $row = $resultSet->fetchAssociative();

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

    public function delete(Uuid $uuid): void
    {
        // Directo
        $this->connection->delete('videos', ['id' => $uuid]);

        //check ¿reuse method, new sql, extract common to private and use in two methods?
//        $sql = "SELECT * FROM videos WHERE id = ?";
//        $stmt = $this->connection->prepare($sql);
//        $stmt->bindValue(1, $uuid);
//        $resultSet = $stmt->executeQuery();
//
//        if (!$resultSet) {
//            //@todo specific exception
//            //throw new \RuntimeException();
//        }
//        $this->connection->delete('videos', ['id' => $uuid]);
    }
}