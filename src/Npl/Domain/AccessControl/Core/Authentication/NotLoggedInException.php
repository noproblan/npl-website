<?php

declare(strict_types=1);

namespace Npl\Domain\AccessControl\Core\Authentication;

use RuntimeException;

class NotLoggedInException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('User is not logged in');
    }
}
