<?php
declare(strict_types=1);

namespace Symfony\Base\User\Aplication;

use Symfony\Base\Shared\Domain\Bus\Query\QueryHandler;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\User\Domain\UserFinder;

class GetUserQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly UserFinder $finder
    )
    {
    }

    /**
     * @throws UserNotExistException
     */
    public function __invoke(GetUserQuery $query): UserResponse
    {
        $user = $this->finder->__invoke(new Uuid($query->id()));

        return new UserResponse(
            $user->id()->value(),
            $user->name()->value(),
            $user->videoCounter()->value(),
        );
    }
}