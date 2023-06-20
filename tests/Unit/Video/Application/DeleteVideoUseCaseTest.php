<?php
declare(strict_types = 1);

namespace Symfony\Base\Tests\Unit\Video\Application;

use PHPUnit\Framework\TestCase;
use Symfony\Base\Shared\Domain\Bus\Event\EventBus;
use Symfony\Base\Tests\Fixtures\Video\VideoMother;
use Symfony\Base\Video\Application\DeleteVideoUseCase;
use Symfony\Base\Video\Domain\VideoFinder;
use Symfony\Base\Video\Domain\VideoRepository;

class DeleteVideoUseCaseTest extends TestCase
{
    private VideoRepository $repository;
    private VideoFinder $finder;
    private EventBus $bus;
    private DeleteVideoUseCase $useCase;

    public function setUp(): void
    {
        $this->repository = $this->createMock(VideoRepository::class);
        $this->finder = $this->createMock(VideoFinder::class);
        $this->bus = $this->createMock(EventBus::class);
        $this->useCase = new DeleteVideoUseCase(
            $this->repository,
            $this->finder,
            $this->bus,
        );
    }

    /**
     * @test
     * */
    public function deleteVideoShouldOk(): void
    {
        $video = VideoMother::create()->random()->build();
        $this->finder
            ->expects(self::once())
            ->method('__invoke')
            ->with($video->uuid())
            ->willReturn($video);

        $this->repository
            ->expects(self::once())
            ->method('delete')
            ->with($video->uuid());

        $this->bus
            ->expects(self::once())
            ->method('publish')
            ->with(...$video->pullDomainEvents());

        $this->useCase->__invoke($video->uuid()->value());
    }

}
