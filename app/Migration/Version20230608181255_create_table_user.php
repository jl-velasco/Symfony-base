
<?php

declare(strict_types=1);

namespace Symfony\Base\App\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230608181255_create_table_user extends AbstractMigration
{
    private const TABLE_NAME = 'user';

    public function getDescription(): string
    {
        return 'Migration for table user';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable(self::TABLE_NAME);
        $table->addColumn('id', 'string', ['notnull' => true, 'length' => 36]);
        $table->addColumn('role', 'integer', ['notnull' => true]);
        $table->addColumn('status', 'integer', ['notnull' => false]);
        $table->addColumn('created_at', 'datetimetz_immutable', ['notnull' => true]);
        $table->addColumn('updated_at', 'datetimetz_immutable', ['notnull' => false]);
        $table->setPrimaryKey(['id']);
        $table->addUniqueIndex(['id']);

        $table = $schema->createTable('account');
        $table->addColumn('id', 'string', ['notnull' => true, 'length' => 36]);
        $table->addColumn('user_id', 'string', ['notnull' => true, 'length' => 36]);
        $table->addColumn('email', 'string', ['notnull' => true]);
        $table->addColumn('password', 'string', ['notnull' => true]);
        $table->addColumn('created_at', 'datetimetz_immutable', ['notnull' => true]);
        $table->addColumn('updated_at', 'datetimetz_immutable', ['notnull' => false]);
        $table->setPrimaryKey(['id']);
        $table->addUniqueIndex(['email']);
        $table->addUniqueIndex(['user_id']);
        $table->addForeignKeyConstraint('"user"', ['user_id'], ['id']);

        $table = $schema->createTable('personal_data');
        $table->addColumn('id', 'string', ['notnull' => true, 'length' => 36]);
        $table->addColumn('account_id', 'string', ['notnull' => false, 'length' => 36]);
        $table->addColumn('first_name', 'string', ['notnull' => false]);
        $table->addColumn('last_name', 'string', ['notnull' => false]);
        $table->addColumn('created_at', 'datetimetz_immutable', ['notnull' => true]);
        $table->addColumn('updated_at', 'datetimetz_immutable', ['notnull' => false]);
        $table->addUniqueIndex(['account_id'], 'personal_data_registered_id_uindex');
        $table->setPrimaryKey(['id']);
        $table->addForeignKeyConstraint('account', ['account_id'], ['id']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable(self::TABLE_NAME);
        $schema->dropTable('account');
        $schema->dropTable('personal_data');
    }
}