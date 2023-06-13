<?php
declare(strict_types = 1);

namespace Symfony\Base\App\Listener;

use Symfony\Base\Comment\Domain\Exceptions\CommentNotFoundException;
use Symfony\Base\Shared\Domain\Exceptions\InvalidValueException;
use Symfony\Base\User\Dominio\Exceptions\PasswordIncorrectException;
use Symfony\Base\User\Dominio\Exceptions\UserNotFoundException;
use Symfony\Base\Video\Domain\Exceptions\VideoNotFoundException;
use Symfony\Base\Shared\Infrastructure\Exceptions\SqlConnectionException;
use Symfony\Component\HttpFoundation\Response;
use function Lambdish\Phunctional\get;

final class ApiExceptionsHttpStatusCodeMapping
{
    private const DEFAULT_STATUS_CODE = Response::HTTP_INTERNAL_SERVER_ERROR;

    /** @var array<string, int> */
    private array $exceptions = [
        VideoNotFoundException::class => Response::HTTP_NOT_FOUND,
        CommentNotFoundException::class => Response::HTTP_NOT_FOUND,
        SqlConnectionException::class => Response::HTTP_BAD_REQUEST,
        PasswordIncorrectException::class => Response::HTTP_NOT_ACCEPTABLE,

        InvalidValueException::class => Response::HTTP_BAD_REQUEST,
        UserNotFoundException::class => Response::HTTP_NOT_FOUND,

    ];

    public function register(string $exceptionClass, int $statusCode): void
    {
        $this->exceptions[$exceptionClass] = $statusCode;
    }

    public function statusCodeFor(string $exceptionClass): int
    {
        $statusCode = get($exceptionClass, $this->exceptions, self::DEFAULT_STATUS_CODE);

        return $statusCode;
    }
}
