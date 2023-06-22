<?php
declare(strict_types = 1);

namespace Symfony\Base\App\Listener;

use InvalidArgumentException;
use Symfony\Base\Shared\Domain\Exception\InvalidValueException;
use Symfony\Base\User\Domain\Exceptions\UserNotExistException;
use Symfony\Base\Video\Domain\Exceptions\VideoNotFoundException;
use Symfony\Component\HttpFoundation\Response;
use function Lambdish\Phunctional\get;

final class ApiExceptionsHttpStatusCodeMapping
{
    private const DEFAULT_STATUS_CODE = Response::HTTP_INTERNAL_SERVER_ERROR;

    /** @var array<string, int> */
    private array $exceptions = [
        InvalidValueException::class => Response::HTTP_BAD_REQUEST,
        UserNotExistException::class => Response::HTTP_NOT_FOUND,
        VideoNotFoundException::class => Response::HTTP_NOT_FOUND
    ];

    public function register(string $exceptionClass, int $statusCode): void
    {
        $this->exceptions[$exceptionClass] = $statusCode;
    }

    public function statusCodeFor(string $exceptionClass): int
    {
        $statusCode = get($exceptionClass, $this->exceptions, self::DEFAULT_STATUS_CODE);

        if (null === $statusCode) {
            throw new InvalidArgumentException("There are no status code mapping for <{$exceptionClass}>");
        }

        return $statusCode;
    }
}