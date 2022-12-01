<?php

declare(strict_types=1);

namespace Npl\Domain\AccessControl\Application\Authenticate;

use Npl\Domain\Shared\Core\Bus\Command\Command;

final class AuthenticateUserCommand implements Command
{
    public function __construct(private readonly string $username, private readonly string $password)
    {
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
