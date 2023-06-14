<?php
declare(strict_types=1);
namespace Symfony\Base\Video\Aplication;


use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Video\Domain\VideoFinder;
use Symfony\Base\Video\Domain\VideoRepository;
use Symfony\Base\Video\Domain\Exceptions\VideoNotExistException;

class GetVideoUseCase
{
public function __construct(
    private readonly VideoFinder $videoFinder)
{
}

public function __invoke(string $video_id) : VideoResponse
{
   $video=$this->videoFinder->__invoke(new Uuid($video_id));

   return new  VideoResponse(
       $video->video()->value(),
       $video->user()->value(),
       $video->name()->value(),
       $video->description()->value(),
       $video->created()->stringDateTime(),
       $video->updated()->stringDateTime()



   );
}
}
