<?php

declare(strict_types=1);

namespace Symfony\Base\App\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230608201254_create_table_video extends AbstractMigration
{
    private const TABLE_VIDEO = 'video';
    private const TABLE_COMMENTS = 'comment';
    private const TABLE_USER = 'user';

    public function getDescription(): string
    {
        return 'Migration for table video';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable(self::TABLE_VIDEO);
        $table->addColumn('id', 'string', ['notnull' => true]);
        $table->addColumn('user_id', 'string', ['notnull' => true]);
        $table->addColumn('name', 'string', ['notnull' => true]);
        $table->addColumn('description', 'text', ['notnull' => true, 'length' => 1000]);
        $table->addColumn('url', 'string', ['notnull' => true]);
        $table->addColumn('created_at', 'datetimetz_immutable', ['notnull' => true, 'default' => 'CURRENT_TIMESTAMP']);
        $table->addColumn('updated_at', 'datetimetz_immutable', ['notnull' => false]);
        $table->setPrimaryKey(['id']);
        $table->addUniqueIndex(['id']);

        $table = $schema->createTable(self::TABLE_COMMENTS);
        $table->addColumn('id', 'string', ['notnull' => true]);
        $table->addColumn('video_id', 'string', ['notnull' => true]);
        $table->addColumn('message', 'text', ['notnull' => true, 'length' => 5000]);
        $table->addColumn('created_at', 'datetimetz_immutable', ['notnull' => true, 'default' => 'CURRENT_TIMESTAMP']);
        $table->addColumn('updated_at', 'datetimetz_immutable', ['notnull' => false]);
        $table->addForeignKeyConstraint(self::TABLE_VIDEO, ['video_id'], ['id']);
        $table->setPrimaryKey(['id']);
        $table->addUniqueIndex(['id']);

        $table = $schema->createTable(self::TABLE_USER);
        $table->addColumn('id', 'string', ['notnull' => true]);
        $table->addColumn('email', 'string', ['notnull' => true]);
        $table->addColumn('name', 'string', ['notnull' => true]);
        $table->addColumn('password', 'string', ['notnull' => true]);
        $table->addColumn('video_counter', 'int', ['notnull' => true, 'default' => 0]);
        $table->addColumn('created_at', 'datetimetz_immutable', ['notnull' => true, 'default' => 'CURRENT_TIMESTAMP']);
        $table->addColumn('updated_at', 'datetimetz_immutable', ['notnull' => false]);
        $table->setPrimaryKey(['id']);
        $table->addUniqueIndex(['id']);
        $table->addUniqueIndex(['email']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable(self::TABLE_VIDEO);
    }
}
