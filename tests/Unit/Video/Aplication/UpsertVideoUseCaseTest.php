<?php

namespace Symfony\Base\Tests\Unit\Video\Aplication;

use PHPUnit\Framework\TestCase;
use Symfony\Base\Shared\Domain\Bus\Event\EventBus;
use Symfony\Base\Shared\Domain\Exception\InvalidValueException;
use Symfony\Base\Tests\Fixtures\Video\VideoMother;
use Symfony\Base\Video\Aplication\UpsertVideoUseCase;
use Symfony\Base\Video\Domain\Exceptions\VideoNotFoundException;
use Symfony\Base\Video\Domain\Video;
use Symfony\Base\Video\Domain\VideoFinder;
use Symfony\Base\Video\Domain\VideoRepository;

class UpsertVideoUseCaseTest extends TestCase
{
    private VideoRepository $repository;
    private VideoFinder $finder;
    private EventBus $bus;
    private UpsertVideoUseCase $useCase;

    public function setUp(): void
    {
        $this->repository = $this->createMock(VideoRepository::class);
        $this->finder=$this->createMock(VideoFinder::class);
        $this->bus=$this->createMock(EventBus::class);
        $this->useCase = new UpsertVideoUseCase(
            $this->repository,
            $this->finder,
            $this->bus);
    }

    /**
     * @test
     * @throws InvalidValueException
     */
    public function whenSaveVideoShouldOk(): void
    {
        $video=VideoMother::create()->random()->build();

        $this->finder
            ->expects(self::once())
            ->method('__invoke')
            ->with($video->uuid())
            ->willReturn($video);

        $this->repository
            ->expects(self::once())
            ->method('save')
            ->with(self::callback(fn(Video $video)=>$video->uuid()->equals($video->uuid())));


        $this->bus
            ->expects(self::once())
            ->method('publish')
            ->with(...$video->pullDomainEvents());

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
    public function whenSaveVideoIsNotFound(): void
    {
        $video=VideoMother::create()->random()->build();
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
