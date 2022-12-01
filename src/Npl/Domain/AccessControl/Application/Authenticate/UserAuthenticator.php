<?php

declare(strict_types=1);

namespace Npl\Domain\AccessControl\Application\Authenticate;

use Npl\Domain\AccessControl\Application\Ports\AuthRepository;
use Npl\Domain\AccessControl\Core\Authentication\AuthPassword;
use Npl\Domain\AccessControl\Core\Authentication\AuthUser;
use Npl\Domain\AccessControl\Core\Authentication\AuthUsername;
use Npl\Domain\AccessControl\Core\Authentication\InvalidAuthCredentials;
use Npl\Domain\AccessControl\Core\Authentication\InvalidAuthUsername;

final class UserAuthenticator
{
    public function __construct(private readonly AuthRepository $repository)
    {
    }

    public function authenticate(AuthUsername $username, AuthPassword $password): void
    {
        $auth = $this->repository->loadByUsername($username);

        $this->ensureUserExists(
            $auth,
            $username
        );
        $this->ensureCredentialsAreValid(
            $auth,
            $password
        );
    }

    private function ensureUserExists(?AuthUser $auth, AuthUsername $username): void
    {
        if (null === $auth) {
            throw new InvalidAuthUsername($username);
        }
    }

    private function ensureCredentialsAreValid(AuthUser $auth, AuthPassword $password): void
    {
        if (!$auth->isPasswordEqual($password)) {
            throw new InvalidAuthCredentials($auth->getUsername());
        }
    }
}
