<?php

declare(strict_types=1);
namespace Symfony\Base\Video\Infrastructure;

use Symfony\Base\Shared\ValueObject\Uuid;
use Symfony\Base\Video\Domain\Video;
use Symfony\Base\Video\Domain\VideoRepository;

class MySQLVideoRepository implements VideoRepository
{

    private const TABLE_VIDEO = 'video';

    public function save(Video $video): void
    {
        if ($this->search($video->id())) {
            $this->update($video);
        } else {
            $this->insert($video);
        }
    }

    /**
     * @throws Exception
     */
    private function update(User $user): void
    {
        $this->connection->createQueryBuilder()
            ->update(self::TABLE_VIDEO)
            ->set('email', ':email')
            ->set('name', ':name')
            ->set('password', ':password')
            ->set('updated_at', ':updated_at')
            ->where('id = :id')
            ->setParameters([
                'id' => $user->id(),
                'email' => $user->email(),
                'name' => $user->name(),
                'password' => $user->password(),
                'updated_at' => new Date(),
            ])
            ->executeQuery();
    }

    /**
     * @throws Exception
     */
    public function delete(Uuid $id): void
    {
        $this->connection->delete(
            self::TABLE_VIDEO,
            ['id' => $id]
        );
    }

    /**
     * @throws Exception
     */
    private function insert(Video $video): void
    {
        $this->connection->insert(
            self::TABLE_VIDEO,
            [
                'id' => $video->Id(),
                'video_user_id' => $video->Video_User_Id(),
                'description' => $video->Description(),
                'name' => $video->Name(),
                'url' => $video->URL(),
            ]
        );
    }
}