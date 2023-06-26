<?php
declare(strict_types=1);

namespace Symfony\Base\Tests\Functional\User;

use Doctrine\DBAL\Schema\Schema;
use Symfony\Base\Tests\Fixtures\DB\UserTableConnector;
use Symfony\Base\Tests\Fixtures\User\UserMother;
use Symfony\Base\Tests\Functional\FunctionalTestCase;

class UserGetFuctionalTest extends FunctionalTestCase
{
    public function testGetUserShouldOk(): void
    {
        $user = UserMother::create()->random()->build();

        UserTableConnector::insert(
            $this->connection,
            $user->id()->value(),
            $user->email()->value(),
            $user->name()->value(),
            $user->password()->value()
        );

        $response = $this->doJsonRequest(
            'Get',
            "/v1/user/{$user->id()->value()}",
            []
        );
        self::assertEquals(200, $response->getStatusCode());
        $content = json_decode($response->getContent(), TRUE);
        self::assertEquals($user->id()->value(), $content['id']);
    }

    public function testGetUserShouldK0(): void
    {
        $user = UserMother::create()->random()->build();

        $response = $this->doJsonRequest(
            'Get',
            "/v1/user/{$user->id()->value()}",
            []
        );
        self::assertEquals(404, $response->getStatusCode());
    }

    protected function createTables(Schema $schema): void
    {
        UserTableConnector::createTable($schema);
    }
}
