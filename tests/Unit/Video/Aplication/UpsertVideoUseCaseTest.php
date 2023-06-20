<?php

declare(strict_types=1);

namespace Symfony\Base\Tests\Unit\Video\Aplication;

use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Base\Shared\Domain\Bus\Event\EventBus;
use Symfony\Base\Shared\Domain\Exception\InvalidValueException;
use Symfony\Base\Tests\Fixtures\Video\VideoMother;
use Symfony\Base\Video\Aplication\UpsertVideoUseCase;
use PHPUnit\Framework\TestCase;
use Symfony\Base\Video\Domain\Exceptions\VideoNotFoundException;
use Symfony\Base\Video\Domain\Video;
use Symfony\Base\Video\Domain\VideoCreatedDomainEvent;
use Symfony\Base\Video\Domain\VideoFinder;
use Symfony\Base\Video\Domain\VideoRepository;

/**
 * @coversDefaultClass UpsertVideoUseCase
 */
class UpsertVideoUseCaseTest extends TestCase
{
    private VideoRepository&MockObject $repository;
    private VideoFinder&MockObject $finder;
    private EventBus&MockObject $bus;

    private UpsertVideoUseCase $useCase;

    protected function setUp(): void
    {
        $this->repository = $this->createMock(VideoRepository::class);
        $this->finder = $this->createMock(VideoFinder::class);
        $this->bus = $this->createMock(EventBus::class);
        $this->useCase = new UpsertVideoUseCase(
            $this->repository,
            $this->finder,
            $this->bus
        );
    }

    /**
     * @test
     * @throws InvalidValueException
     */
    public function whenANewVideoIsAddThenVideoCreatedEventIsFired(): void
    {
        $video = VideoMother::create()->random()->build();
        $this->finder->expects(self::once())
            ->method('__invoke')
            ->with($video->uuid())
            ->willThrowException(new VideoNotFoundException($video->uuid()->value()));
        $this->repository->expects(self::once())
            ->method('save')
            ->with(self::callback(fn (Video $arg) => $arg->uuid()->equals($video->uuid())));
        $this->bus->expects(self::once())
            ->method('publish')
            ->with(self::callback(fn(VideoCreatedDomainEvent $event) => $event->aggregateId() === $video->uuid()->value()));
        $this->useCase->__invoke(
            $video->uuid()->value(),
            $video->userUuid()->value(),
            $video->name()->value(),
            $video->description()->value(),
            $video->url()->value()
        );
    }

    /**
     * @test
     * @throws InvalidValueException
     */
    public function whenAVideoIsEditedNoEventIsFired(): void
    {
        $video = VideoMother::create()->random()->build();
        $this->finder->expects(self::once())
            ->method('__invoke')
            ->with($video->uuid())
            ->willReturn($video);
        $this->repository->expects(self::once())
            ->method('save')
            ->with(self::callback(fn (Video $arg) => $arg->uuid()->equals($video->uuid())));
        $this->bus->expects(self::once())
            ->method('publish');
        $this->useCase->__invoke(
            $video->uuid()->value(),
            $video->userUuid()->value(),
            $video->name()->value(),
            $video->description()->value(),
            $video->url()->value()
        );
    }
}
