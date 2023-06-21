<?php
declare(strict_types=1);

namespace Symfony\Base\Tests\Fixtures\DB;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\DBAL\Schema\Schema;
use Exception;
use Symfony\Base\Shared\Domain\Exception\InternalErrorException;
use Symfony\Base\Shared\Domain\ValueObject\Date;

class UserTableConnector
{
    public const TABLE_USER = 'user';

    public static function createTable(Schema $schema): void
    {
        $table = $schema->createTable('user');
        $table->addColumn('id', 'string', ['notnull' => true]);
        $table->addColumn('email', 'string', ['notnull' => true]);
        $table->addColumn('name', 'string', ['notnull' => true]);
        $table->addColumn('password', 'string', ['notnull' => true]);
        $table->addColumn('video_counter', 'integer', ['notnull' => true, 'default' => 0]);
        $table->addColumn('created_at', 'datetimetz_immutable', ['notnull' => true]);
        $table->addColumn('updated_at', 'datetimetz_immutable', ['notnull' => false]);
        $table->setPrimaryKey(['id']);
        $table->addUniqueIndex(['id']);
        $table->addUniqueIndex(['email']);
    }

    public static function insert(
        Connection $connection,
        string $id,
        string $email,
        string $name,
        string $password,
        ?int $videoCounter = 0
    ): void {
        try {
            $connection->insert(
                self::TABLE_USER,
                [
                    'id' => $id,
                    'email' => $email,
                    'name' => $name,
                    'password' => $password,
                    'video_counter' => $videoCounter,
                    'created_at' => (new Date())->stringDateTime(),
                ]
            );
        } catch (UniqueConstraintViolationException|Exception $exception) {
            throw new InternalErrorException($exception->getMessage());
        }
    }

}