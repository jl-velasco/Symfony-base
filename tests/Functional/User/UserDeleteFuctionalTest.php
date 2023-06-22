<?php
declare(strict_types=1);

namespace Symfony\Base\Tests\Functional\User;

use Doctrine\DBAL\Schema\Schema;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Tests\Fixtures\DB\UserTableConnector;
use Symfony\Base\Tests\Fixtures\User\UserMother;
use Symfony\Base\Tests\Functional\FunctionalTestCase;

class UserDeleteFuctionalTest extends FunctionalTestCase
{
    public function testDeleteUserShouldOk(): void
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


    protected function createTables(Schema $schema): void
    {
        UserTableConnector::createTable($schema);
    }
}