<?php

namespace Symfony\Base\Tests\Unit\Video\Aplication;

use PHPUnit\Framework\TestCase;
use Symfony\Base\Shared\Domain\Bus\Event\EventBus;
use Symfony\Base\Video\Aplication\UpsertVideoUseCase;
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
        $this->useCase = new UpsertVideoUseCase($this->repository, $this->finder, $this->bus);
    }

    /**
     * @test
     */
    public function whenSaveVideoShouldOk(): void
    {

    }
}
