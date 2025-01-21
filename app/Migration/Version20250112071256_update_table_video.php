<?php

declare(strict_types=1);

namespace Symfony\Base\App\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250112071256_update_table_video extends AbstractMigration
{
    private const TABLE_VIDEO = 'video';

    public function getDescription(): string
    {
        return 'Migration for table video';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->getTable(self::TABLE_VIDEO);
        $table->addColumn('likes', 'integer', ['notnull' => true, 'default' => 0]);
    }

    public function down(Schema $schema): void
    {
        $table = $schema->getTable(self::TABLE_VIDEO);
        $table->dropColumn('likes');
    }
}
