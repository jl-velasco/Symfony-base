<?php

declare(strict_types=1);

namespace Symfony\Base\App\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Symfony\Base\Shared\Domain\ValueObject\Date;

class Version20230614184554_create_table_user_stats extends AbstractMigration
{
    private const TABLE_NAME = 'stats';

    public function getDescription(): string
    {
        return 'Migration for table stats';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable(self::TABLE_NAME);
        $table->addColumn('id', 'string', ['notnull' => true]);
        $table->addColumn('videos', 'int', ['notnull' => true, 'default' => 0]);
        $table->addColumn('updated_at', 'datetimetz_immutable', ['notnull' => false]);
        $table->addForeignKeyConstraint('user', ['id'], ['id']);
        $table->setPrimaryKey(['id']);
        $table->addUniqueIndex(['id']);

        $countQuery = $this->connection->createQueryBuilder();
        $countQuery->select('user_id, COUNT(*) as video_count')
            ->from('video')
            ->groupBy('user_id');

        $insertQuery = $this->connection->createQueryBuilder();
        $insertQuery->insert('stats')
            ->values(['user_id' => ':user_id', 'videos' => ':video_count', 'updated_at']);

        $countResults = $countQuery->executeQuery()->fetchAllAssociative();
        foreach ($countResults as $result) {
            $insertQuery->setParameters([
                ':user_id' => $result['user_id'],
                ':video_count' => $result['video_count'],
                ':updated_at' => (new Date())->stringDateTime(),
            ])->executeQuery();
        }
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable(self::TABLE_NAME);
    }
}