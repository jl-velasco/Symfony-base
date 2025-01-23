<?php

declare(strict_types=1);

namespace Symfony\Base\Tests;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

/**
 * @internal
 */
class DbalTestCase extends KernelTestCase
{
    protected static ?EntityManagerInterface $entityManager = null;
    protected static ?Connection $connection = null;

    /**
     * @throws \Exception
     */
    protected function setUp(): void
    {
        self::bootKernel();

        self::$entityManager = self::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        self::$connection = self::$entityManager->getConnection();

        $schemaTool = new SchemaTool(self::$entityManager);
        $schemaTool->dropDatabase();

        $application = new Application(self::$kernel);
        $application->setAutoExit(false);

        $input = new ArrayInput([
            'command' => 'doctrine:migrations:migrate',
            '--no-interaction' => true,
        ]);

        $application->run($input, new NullOutput());
    }

    public function connection(): Connection
    {
        return self::$connection;
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        if (self::$entityManager) {
            $schemaTool = new SchemaTool(self::$entityManager);
            $schemaTool->dropDatabase();
            self::$entityManager->close();
            self::$entityManager = null;
        }
    }

    /**
     * @throws Exception
     *
     * @return array<mixed>
     */
    protected static function fetchAll(string $tableName): array
    {
        return self::$connection
            ->executeQuery("SELECT * FROM {$tableName}")
            ->fetchAllAssociative();
    }
}
