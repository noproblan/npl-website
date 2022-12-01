<?php

declare(strict_types=1);

namespace Npl\Domain\AccessControl\Application\Authenticate;

use Npl\Domain\AccessControl\Core\Authentication\AuthPassword;
use Npl\Domain\AccessControl\Core\Authentication\AuthUsername;
use Npl\Domain\Shared\Core\Bus\Command\CommandHandler;

/**
 * @implements CommandHandler<AuthenticateUserCommand>
 */
final class AuthenticateUserCommandHandler implements CommandHandler
{
    public function __construct(private readonly UserAuthenticator $authenticator)
    {
    }

    public function __invoke(mixed $command): void
    {
        $username = new AuthUsername($command->getUsername());
        $password = new AuthPassword($command->getPassword());

        $this->authenticator->authenticate(
            $username,
            $password
        );
    }
}
