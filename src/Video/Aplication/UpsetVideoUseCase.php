<?php

namespace Symfony\Base\Video\Aplication;


use _PHPStan_a3459023a\Nette\InvalidArgumentException;
use http\Exception\RuntimeException;
use Symfony\Base\Shared\ValueObject\Description;
use Symfony\Base\Shared\ValueObject\Name;
use Symfony\Base\Shared\ValueObject\Url;
use Symfony\Base\Shared\ValueObject\Uuid;
use Symfony\Base\Video\Domain\Video;
use Symfony\Base\Video\Domain\VideoRepository;

class UpsetVideoUseCase
{
    public function __construct(
        private readonly VideoRepository $repository)
    {
    }

    public function __invoke(string $video_id,
                             string $video_user_id,
                             string $name,
                             string $description,
                             string $url,
    ): void
    {
        try{
        $this->repository->save(
            new Video(
                new Uuid($video_id),
                new Uuid($video_user_id),
                new Name($name),
                new Description($description),
                new Url($url)
            )
        );
        }catch (\InvalidArgumentException $exception){
        throw new InvalidArgumentException("El tipo de dato no es el adecuado");
        } catch (\Exception $exception){
            throw new RuntimeException('Ocurrio un error inesperado');
        }
    }

}
