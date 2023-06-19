<?php

declare(strict_types=1);

namespace Symfony\Base\App\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230608181254_create_table_user extends AbstractMigration
{
    private const TABLE_NAME = 'user';

    public function getDescription(): string
    {
        return 'Migration for table user';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable(self::TABLE_NAME);
        $table->addColumn('id', 'string', ['notnull' => true, 'length' => 191]);
        $table->addColumn('email', 'string', ['notnull' => true, 'length' => 191]);
        $table->addColumn('name', 'string', ['notnull' => true, 'length' => 191]);
        $table->addColumn('password', 'string', ['notnull' => true, 'length' => 191]);
        $table->addColumn('created_at', 'datetimetz_immutable', ['notnull' => true, 'default' => 'CURRENT_TIMESTAMP']);
        $table->addColumn('updated_at', 'datetimetz_immutable', ['notnull' => false]);
        $table->addColumn('videoCount', 'integer', ['default' => 0]);
        $table->setPrimaryKey(['id']);
        $table->addUniqueIndex(['id']);
        $table->addUniqueIndex(['email']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable(self::TABLE_NAME);
    }
}
