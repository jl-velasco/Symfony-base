<?php
declare(strict_types = 1);
namespace Symfony\Base\Video\Domain;

use Symfony\Base\Shared\ValueObject\Uuid;
use Symfony\Base\Video\Domain\Exceptions\VideoNotExistException;

final class VideoFinder
{
    public function __construct(
        private readonly VideoRepository $videoRepository){

    }
    /**
     * @throws VideoNotExistException
     */
    public function __invoke(Uuid $video_id) : Video{
        $video = $this->videoRepository->search($video_id);
        if ($video === null){
            throw new VideoNotExistException((string)$video_id);
        }
        return $video;
    }
}
