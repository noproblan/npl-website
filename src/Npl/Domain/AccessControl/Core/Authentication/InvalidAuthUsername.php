<?php

declare(strict_types=1);

namespace Npl\Domain\AccessControl\Core\Authentication;

use RuntimeException;

class InvalidAuthUsername extends RuntimeException
{
    public function __construct(AuthUsername $username)
    {
        parent::__construct(
            sprintf(
                'The user "%s" does not exist',
                $username->getValue()
            )
        );
    }
}
