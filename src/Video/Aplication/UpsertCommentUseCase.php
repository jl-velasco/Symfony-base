<?php

namespace Symfony\Base\Video\Aplication;

use Symfony\Base\Comment\Aplication\InvalidValueException;
use Symfony\Base\Comment\Domain\Comment;
use Symfony\Base\Comment\Domain\CommentRepository;
use Symfony\Base\Shared\Domain\ValueObject\Description;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Video\Domain\VideoRepository;

class UpsertCommentUseCase
{
    /// IMPORTANTE EL COMENTARIO ES UN AGREGADO DEL VIDEO
    /// AGREGADO ES EL PADRE == VIDEO
    /// CAMBIOS TRANSACCIONARES
    /// PEDIDO TIEEN QUE TENER UN METODO AÑADIR LINEA DE PEDIDO Y ALLI GUARDAR
    /// NO HAY DOS REPOSITORIOS
    public function __construct(
        private readonly VideoRepository $VideoRepository
    )
    {
    }

    /**
     * @throws InvalidValueException
     */
    public function __invoke(
        string $uuid,
        string $video_id,
        string $mensaje
    ): void
    {
        // encuentro el video
        $Video = $this->VideoRepository->find(new Uuid($video_id));
        $Video->comment($mensaje);
        print_R($Video);
        // eoncontrar por el
        $this->mySqlVideoRepository->save(
            $Video
        );
        /* VALIDAR CON NO ESTA REPETIDO */
        /* TODO FACTORTY*/
        /*
          new Comment(
              new Uuid($uuid),
              new Uuid($video_Uuid),
              new Description($mensaje)
          )*/
    }
}