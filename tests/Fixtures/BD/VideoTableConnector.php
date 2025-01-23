<?php

namespace Fixtures\BD;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Schema;
use Symfony\Base\Video\Video\Domain\Video;

class VideoTableConnector
{
    public static function insert(Connection $connection, Video $video): void
    {
        $connection->insert('video', [
            'id' => $video->id()->value(),
            'user_id' => $video->userId()->value(),
            'url' => $video->url()->value(),
            'name' => $video->name()->value(),
            'description' => $video->description()->value(),
            'likes' => $video->likes()->value(),
            'created_at' => $video->createdAt()->stringDateTime(),
            'updated_at' => $video->updatedAt()?->stringDateTime(),
        ]);
    }
}