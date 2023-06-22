<?php
declare(strict_types=1);

namespace Symfony\Base\Tests\Functional\User;

use Doctrine\DBAL\Schema\Schema;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Tests\Fixtures\DB\UserTableConnector;
use Symfony\Base\Tests\Fixtures\User\UserMother;
use Symfony\Base\Tests\Functional\FunctionalTestCase;

class UserPutFuctionalTest extends FunctionalTestCase
{
    public function testCreateUserShouldOk(): void
    {
        $user = UserMother::create()->random()->build();

        $response = $this->doJsonRequest(
            'PUT',
            "/v1/user/{$user->id()->value()}",
            [
                'email' => $user->email()->value(),
                'name' => $user->name()->value(),
                'password' => $user->password()->value()
            ]
        );
        self::assertEquals(200, $response->getStatusCode());
    }

    public function dataProviderForCreateUser(): array
    {
        return [
            'email is empty' => [
                'params' => [
                    'email' => '',
                    'name' => 'name',
                    'password' => 'password',
                    'expected' => 400
                ],
            ],
            'name is empty' => [
                'params' => [
                    'email' => 'email@email.com',
                    'name' => '',
                    'password' => 'password',
                    'expected' => 200
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForCreateUser
     */
    public function testCreateUserShouldKo($params): void
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
            'PUT',
            "/v1/user/{$user->id()->value()}",
            []
        );
        self::assertEquals(200, $response->getStatusCode());
    }

    protected function createTables(Schema $schema): void
    {
        UserTableConnector::createTable($schema);
    }
}