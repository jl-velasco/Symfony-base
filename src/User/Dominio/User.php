<?php
declare(strict_types=1);

namespace Symfony\Base\User\Dominio;

use Symfony\Base\Shared\ValueObject\Date;
use Symfony\Base\Shared\ValueObject\Email;
use Symfony\Base\Shared\ValueObject\Name;
use Symfony\Base\Shared\ValueObject\Uuid;

final class User
{
    public function __construct(
        private readonly Uuid $id,
        private readonly Email $email,
        private readonly Name $name,
        private readonly Password $password,
        private readonly Date $created_at,
        private readonly Date $updated_at,

    )
    {
    }

    public function id(): Uuid
    {
        return $this->id;
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function name(): Name
    {
        return $this->name;
    }

    public function password(): Password
    {
        return $this->password;
    }

    /**
     * @return Date
     */
    public function createdAt(): Date
    {
        return $this->created_at;
    }

    /**
     * @return Date
     */
    public function updatedAt(): Date
    {
        return $this->updated_at;
    }


}