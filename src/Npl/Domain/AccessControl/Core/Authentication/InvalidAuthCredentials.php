<?php

declare(strict_types=1);

namespace Npl\Domain\AccessControl\Core\Authentication;

use RuntimeException;

class InvalidAuthCredentials extends RuntimeException
{
    public function __construct(AuthUsername $username)
    {
        parent::__construct(
            sprintf(
                'The credentials for "%s" are invalid',
                $username->getValue()
            )
        );
    }
}
