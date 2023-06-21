<?php

namespace Symfony\Base\Tests\Unit\Video\Application;

use PHPUnit\Framework\TestCase;
use Symfony\Base\Shared\Domain\Bus\Event\EventBus;
use Symfony\Base\Shared\Domain\ValueObject\Name;
use Symfony\Base\Tests\Fixtures\Video\VideoMother;
use Symfony\Base\Video\Aplication\UpsertVideoUseCase;
use Symfony\Base\Video\Domain\Exceptions\VideoNotFoundException;
use Symfony\Base\Video\Domain\VideoCreatedDomainEvent;
use Symfony\Base\Video\Domain\VideoFinder;
use Symfony\Base\Video\Domain\VideoRepository;

class UpsertVideoUseCaseTest extends TestCase
{
    private VideoRepository $repository;
    private readonly VideoFinder $finder;
    private readonly EventBus $bus;
    private UpsertVideoUseCase $useCase;

    public function setUp(): void
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
     * */
    public function whenInsertVideoShouldOk(): void
    {
        $video = VideoMother::create()->random()->build();

        $this->finder
            ->expects(self::once())
            ->method('__invoke')
            ->with($video->uuid())
            ->willThrowException(new VideoNotFoundException($video->uuid()->value()));

        $this->repository
            ->expects(self::once())
            ->method('save');

        $this->bus
            ->expects(self::once())
            ->method('publish')
            ->with(self::callback(static fn(VideoCreatedDomainEvent $event) => $event->aggregateId() === $video->uuid()->value()));

        $this->useCase->__invoke(
            $video->uuid()->value(),
            $video->userUuid()->value(),
            $video->name()->value(),
            $video->description()->value(),
            $video->url()->value(),
        );
    }

    /**
     * @test
     * */
    public function whenUpdateVideoShouldOk(): void
    {
        $video = VideoMother::create()->random()->build();

        $this->finder
            ->expects(self::once())
            ->method('__invoke')
            ->with($video->uuid())
            ->willReturn($video);

        $this->repository
            ->expects(self::once())
            ->method('save');

        $this->bus
            ->expects(self::once())
            ->method('publish');

        $this->useCase->__invoke(
            $video->uuid()->value(),
            $video->userUuid()->value(),
            $video->name()->value(),
            $video->description()->value(),
            $video->url()->value(),
        );
    }
}