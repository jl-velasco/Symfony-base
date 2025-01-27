<?php

namespace Symfony\Base\Tests\Unit\Video\Video\Application;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Base\Tests\Unit\Mother\Domain\VideoMother;
use Symfony\Base\Video\Video\Application\CreateVideoUseCase;
use Symfony\Base\Video\Video\Application\DTOVideo;
use Symfony\Base\Video\Video\Domain\Exceptions\VideoAlreadyExistsException;
use Symfony\Base\Video\Video\Domain\Exceptions\VideoNotFound;
use Symfony\Base\Video\Video\Domain\VideoFinder;
use Symfony\Base\Video\Video\Domain\VideoRepository;

class CreateVideoUseCaseTest extends TestCase
{
    private VideoFinder&MockObject $finder;
    private VideoRepository&MockObject $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->finder = $this->createMock(VideoFinder::class);
        $this->repository = $this->createMock(VideoRepository::class);
        $this->useCase = new CreateVideoUseCase(
            $this->repository,
            $this->finder
        );
    }

    public function testCreateVideoShouldOk(): void
    {
        $videoMother = VideoMother::create()->build();

        $this->finder
            ->expects(self::once())
            ->method('findById')
            ->willThrowException(new VideoNotFound());

        $this->repository
            ->expects(self::once())
            ->method('save');

        $this->useCase->__invoke(
            new DTOVideo(
                $videoMother->id()->value(),
                $videoMother->userId()->value(),
                $videoMother->name()->value(),
                $videoMother->description()->value(),
                $videoMother->url()->value()
            )
        );
    }

    public function testCreateVideoShouldKo(): void
    {
        $videoMother = VideoMother::create()->build();

        $this->finder
            ->expects(self::once())
            ->method('findById')
            ->willReturn($videoMother);

        $this->repository
            ->expects(self::never())
            ->method('save');

        $this->expectException(VideoAlreadyExistsException::class);
        $this->useCase->__invoke(
            new DTOVideo(
                $videoMother->id()->value(),
                $videoMother->userId()->value(),
                $videoMother->name()->value(),
                $videoMother->description()->value(),
                $videoMother->url()->value()
            )
        );
    }
}