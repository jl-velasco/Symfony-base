<?php

declare(strict_types = 1);

namespace Symfony\Base\Tests\Functional;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\HttpFoundation\Response;

abstract class FunctionalTestCase extends WebTestCase
{
    public const POST = 'POST';
    public const GET = 'GET';
    public const PUT = 'PUT';
    public const DELETE = 'DELETE';
    public const PATCH = 'PATCH';

    protected KernelBrowser $client;
    protected static ?EntityManagerInterface $entityManager = null;
    protected static ?Connection $connection = null;

    /**
     * @throws \Exception
     */
    protected function setUp(): void
    {
        $this->client = self::createClient();
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

    protected function getDiContainer(): ContainerInterface
    {
        return self::getContainer();
    }

    /**
     * @param array<string, mixed> $jsonParams
     * @param array<string, mixed> $headerParams
     */
    protected function doJsonRequest(
        string $method,
        string $uri,
        array $jsonParams = [],
        ?string $token = null,
        array $headerParams = []
    ): Response {
        $validHttpMethods = [
            self::GET,
            self::POST,
            self::PUT,
            self::DELETE,
            self::PATCH,
        ];
        if (!\in_array($method, $validHttpMethods, true)) {
            throw new \InvalidArgumentException(sprintf('Invalid HTTP method: %s', $method));
        }

        $defaultHeaders = ['HTTP_CONTENT_TYPE' => 'application/json'];
        if ($token) {
            $defaultHeaders['HTTP_AUTHORIZATION'] = sprintf('Bearer %s', $token);
        } else {
            $defaultHeaders['HTTP_AUTHORIZATION'] = sprintf('Bearer %s', $_ENV['API_AUTH_TOKEN']);
        }
        $headers = array_merge($defaultHeaders, $headerParams);

        try {
            $jsonEncode = json_encode($jsonParams, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            throw new \RuntimeException('Failed to encode JSON parameters', 0, $e);
        }

        $this->client->request(
            $method,
            $uri,
            [],
            [],
            $headers,
            $jsonEncode
        );

        return $this->client->getResponse();
    }

    /**
     * @param array<string, string> $params
     */
    protected function doRequest(string $method, string $uri, array $params = []): Response
    {
        $this->client->request($method, $uri, $params);

        return $this->client->getResponse();
    }

    /**
     * @throws Exception
     *
     * @return array<int, array<string, mixed>>
     */
    protected function getAllFromRepository(string $tableName): array
    {
        return self::$connection->fetchAllAssociative("SELECT * FROM {$tableName}");
    }
}
