<?php
declare(strict_types=1);


namespace Symfony\Base\User\Aplication;


use Symfony\Base\Shared\Exception\InvalidValueException;
use Symfony\Base\Shared\ValueObject\Uuid;
use Symfony\Base\Video\Dominio\Video;
use Symfony\Base\Video\Dominio\VideoRepository;

class FindVideoUseCase
{


    public function __construct(
        private readonly VideoRepository $repository
    )
    {
    }


    /**
     * @throws InvalidValueException
     */
    public function __invoke(
        string $id
    ): Video
    {
        return $this->repository->search(new Uuid($id));
    }
}
