<?php

declare(strict_types=1);

namespace Npl\Domain\AccessControl\Core\Authentication;

final class AuthUser
{
    public function __construct(private readonly AuthUsername $username, private readonly AuthPassword $password)
    {
    }

    public function isPasswordEqual(AuthPassword $password): bool
    {
        return $this->password->isEqual($password);
    }

    public function getUsername(): AuthUsername
    {
        return $this->username;
    }
}
