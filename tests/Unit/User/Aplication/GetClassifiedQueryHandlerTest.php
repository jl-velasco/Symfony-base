<?php

declare(strict_types=1);

namespace Symfony\Base\Tests\Unit\User\Aplication;

use JsonSchema\Exception\ResourceNotFoundException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Base\Shared\Domain\Exception\InternalErrorException;
use Symfony\Base\Shared\Domain\Exception\InvalidValueException;
use Symfony\Base\User\Aplication\GetUserUseCase;
use Symfony\Base\User\Domain\UserRepository;
use Symfony\Base\Video\Domain\Video;

/**
 * @internal
 */
class GetClassifiedQueryHandlerTest extends TestCase
{
    /** @var UserRepository&MockObject */
    private mixed $repository;

    private GetUserUseCase $useCase;

    protected function setUp(): void
    {
        $this->repository = $this->createMock(UserRepository::class);
        $this->useCase = new GetUserUseCase($this->repository);
    }

    /**
     * @test
     *
     * @throws ResourceNotFoundException
     * @throws InternalErrorException
     * @throws InvalidValueException
     */
    public function whenUserDoesNotExistRaisesResourceNotFoundException(): void
    {
        $uuid = Video::random();
        $this->repository
            ->expects(self::once())
            ->method('search')
            ->with($uuid)
            ->willReturn(null);

        $this->useCase->__invoke($uuid->value());
    }
}
