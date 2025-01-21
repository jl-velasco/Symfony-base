<?php

declare(strict_types=1);

namespace Symfony\Base\App\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250112071254_update_table_tweet extends AbstractMigration
{
    private const TABLE_TWEETS = 'tweet';

    public function getDescription(): string
    {
        return 'Migration for table video';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->getTable(self::TABLE_TWEETS);
        $table->addColumn('likes', 'integer', ['notnull' => true, 'default' => 0]);
    }

    public function down(Schema $schema): void
    {
        $table = $schema->getTable(self::TABLE_TWEETS);
        $table->dropColumn('likes');
    }
}
