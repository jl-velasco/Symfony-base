<?php
declare(strict_types = 1);

namespace Symfony\Base\Tests\Unit\Video\Application;

use PHPUnit\Framework\TestCase;
use Symfony\Base\Shared\Domain\Bus\Event\EventBus;
use Symfony\Base\Tests\Fixtures\Video\VideoMother;
use Symfony\Base\Video\Application\UpsertVideoUseCase;
use Symfony\Base\Video\Domain\VideoFinder;
use Symfony\Base\Video\Domain\VideoRepository;


class UpsertVideoUseCaseTest extends TestCase
{
    private VideoRepository $repository;
    private VideoFinder $finder;
    private EventBus $eventBus;
    private UpsertVideoUseCase $useCase;

    public function setUp(): void
    {
        $this->repository = $this->createMock(VideoRepository::class);
        $this->finder = $this->createMock(VideoFinder::class);
        $this->eventBus = $this->createMock(EventBus::class);
        $this->useCase = new UpsertVideoUseCase(
            $this->repository,
            $this->finder,
            $this->eventBus
        );
    }

    /**
     * @test
     * */
    public function whenSaveVideoShouldOk(): void
    {
        $video = VideoMother::create()->random()->build();

        $this->repository
            ->expects(self::once())
            ->method('save');

        $this->useCase->__invoke(
            $video->uuid()->value(),
            $video->userUuid()->value(),
            $video->name()->value(),
            $video->description()->value(),
            $video->url()->value(),
        );

    }

}
