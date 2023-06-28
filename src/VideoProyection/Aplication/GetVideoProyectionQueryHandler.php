<?php
declare(strict_types=1);

namespace Symfony\Base\Video\Aplication;

use Symfony\Base\Shared\Domain\Bus\Query\QueryHandler;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\User\Domain\UserFinder;
use Symfony\Base\VideoProyection\Domain\VideoProyectionFinder;

class GetVideoProyectionQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly VideoProyectionFinder $finder
    )
    {
    }

    /**
     * @throws UserNotExistException
     */
    public function __invoke(GetVideoQuery $query): GetVideoProyectionQuery
    {
        $user = $this->finder->__invoke(new Uuid($query->id()));

        return new VideoProyectionResponse(
            $user->id()->value(),
            $user->name()->value(),
            $user->comments()->value(),
        );
    }
}
