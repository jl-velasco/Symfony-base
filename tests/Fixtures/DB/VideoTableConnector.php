<?php

declare(strict_types=1);

namespace Symfony\Base\Tests\Fixtures\DB;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\DBAL\Schema\Schema;
use Exception;
use Symfony\Base\Shared\Domain\Exception\InternalErrorException;
use Symfony\Base\Video\Studio\Domain\Video;

class VideoTableConnector
{
    public const TABLE_VIDEO = 'video';
    public const TABLE_COMMENT = 'comment';

    public static function create(Schema $schema): void
    {
        $table = $schema->createTable(self::TABLE_VIDEO);
        $table->addColumn('id', 'string', ['notnull' => true]);
        $table->addColumn('user_id', 'string', ['notnull' => true]);
        $table->addColumn('name', 'string', ['notnull' => true]);
        $table->addColumn('description', 'text', ['notnull' => true, 'length' => 1000]);
        $table->addColumn('url', 'string', ['notnull' => true]);
        $table->addColumn('created_at', 'datetimetz_immutable', ['notnull' => true]);
        $table->addColumn('updated_at', 'datetimetz_immutable', ['notnull' => false]);
        $table->setPrimaryKey(['id']);

        $table = $schema->createTable(self::TABLE_COMMENT);
        $table->addColumn('id', 'string', ['notnull' => true]);
        $table->addColumn('video_id', 'string', ['notnull' => true]);
        $table->addColumn('message', 'text', ['notnull' => true, 'length' => 5000]);
        $table->addColumn('created_at', 'datetimetz_immutable', ['notnull' => true]);
        $table->addColumn('updated_at', 'datetimetz_immutable', ['notnull' => false]);
        $table->setPrimaryKey(['id']);
    }

    /**
     * @throws InternalErrorException
     */
    public static function insert(
        Connection $connection,
        Video $video,
    ): void {
        try {
            $connection->insert(
                self::TABLE_VIDEO,
                [
                    'id' => $video->uuid()->value(),
                    'user_id' => $video->userUuid()->value(),
                    'name' => $video->name()->value(),
                    'description' => $video->description()->value(),
                    'url' => $video->url()->value(),
                    'created_at' => $video->createdAt()?->stringDateTime()
                ]
            );

            foreach ($video->comments() as $comment) {
                $connection->insert(
                    self::TABLE_COMMENT,
                    [
                        'id' => $comment->id(),
                        'video_id' => $comment->videoId(),
                        'message' => $comment->message(),
                        'created_at' => $comment->createdAt()->stringDateTime()
                    ]
                );
            }
        } catch (UniqueConstraintViolationException|Exception $exception) {
            throw new InternalErrorException($exception->getMessage());
        }
    }
}
