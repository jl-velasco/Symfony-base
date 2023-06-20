<?php
declare(strict_types = 1);

namespace Symfony\Base\Tests\Unit\Video\Domain;

use PHPUnit\Framework\TestCase;
use Symfony\Base\Shared\Domain\Exceptions\InvalidValueException;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Tests\Fixtures\Video\VideoMother;
use Symfony\Base\Video\Domain\VideoFinder;
use Symfony\Base\Video\Domain\VideoRepository;

class VideoFinderTest extends TestCase
{
    private VideoRepository $repository;
    private VideoFinder $useCase;

    public function setUp(): void
    {
        $this->repository = $this->createMock(VideoRepository::class);
        $this->useCase = new VideoFinder($this->repository);
    }

    /**
     * @test
     * */
    public function whenVideoNotExistShouldThrowException(): void
    {
        $this->expectException(InvalidValueException::class);
        $this->useCase->__invoke(new Uuid('123'));
    }

    /**
     * @test
     * */
    public function whenVideoExistShouldVideo(): void
    {
        $videoMother = VideoMother::create()->random()->build();
        $this->repository
            ->expects(self::once())
            ->method('find')
            ->with($videoMother->uuid())
            ->willReturn($videoMother);

        $video = $this->useCase->__invoke($videoMother->uuid());
        self::assertEquals($video->uuid()->value(), $videoMother->uuid()->value());
    }

}
