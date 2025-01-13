<?php

declare(strict_types=1);

namespace Symfony\Base\App\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250112071254_create_table_tweet extends AbstractMigration
{
    private const TABLE_TWEETS = 'tweet';
    private const TABLE_TWEET_COMMENTS = 'tweet_comment';
    private const TABLE_TWEET_LIKES = 'tweet_like';

    public function getDescription(): string
    {
        return 'Migration for table video';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable(self::TABLE_TWEETS);
        $table->addColumn('id', 'string', ['notnull' => true]);
        $table->addColumn('user_id', 'string', ['notnull' => true]);
        $table->addColumn('content', 'text', ['notnull' => true, 'length' => 280]);
        $table->addColumn('created_at', 'datetimetz_immutable', ['notnull' => true, 'default' => 'CURRENT_TIMESTAMP']);
        $table->addColumn('updated_at', 'datetimetz_immutable', ['notnull' => false]);
        $table->setPrimaryKey(['id']);
        $table->addUniqueIndex(['id']);

        $table = $schema->createTable(self::TABLE_TWEET_COMMENTS);
        $table->addColumn('id', 'string', ['notnull' => true]);
        $table->addColumn('tweet_id', 'string', ['notnull' => true]);
        $table->addColumn('user_id', 'string', ['notnull' => true]);
        $table->addColumn('content', 'text', ['notnull' => true, 'length' => 280]);
        $table->addColumn('created_at', 'datetimetz_immutable', ['notnull' => true, 'default' => 'CURRENT_TIMESTAMP']);
        $table->addColumn('updated_at', 'datetimetz_immutable', ['notnull' => false]);
        $table->addForeignKeyConstraint(self::TABLE_TWEETS, ['tweet_id'], ['id']);
        $table->setPrimaryKey(['id']);
        $table->addUniqueIndex(['id']);

        $table = $schema->createTable(self::TABLE_TWEET_LIKES);
        $table->addColumn('id', 'string', ['notnull' => true]);
        $table->addColumn('tweet_id', 'string', ['notnull' => true]);
        $table->addColumn('user_id', 'string', ['notnull' => true]);
        $table->addColumn('created_at', 'datetimetz_immutable', ['notnull' => true, 'default' => 'CURRENT_TIMESTAMP']);
        $table->addForeignKeyConstraint(self::TABLE_TWEETS, ['tweet_id'], ['id']);
        $table->setPrimaryKey(['id']);
        $table->addUniqueIndex(['id']);
        $table->addUniqueIndex(['tweet_id', 'user_id']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable(self::TABLE_TWEETS);
        $schema->dropTable(self::TABLE_TWEET_COMMENTS);
        $schema->dropTable(self::TABLE_TWEET_LIKES);
    }
}
