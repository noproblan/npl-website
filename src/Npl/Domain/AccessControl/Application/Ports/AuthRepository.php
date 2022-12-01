<?php

declare(strict_types=1);

namespace Npl\Domain\AccessControl\Application\Ports;

use Npl\Domain\AccessControl\Core\Authentication\AuthUser;
use Npl\Domain\AccessControl\Core\Authentication\AuthUsername;

interface AuthRepository
{
    public function loadByUsername(AuthUsername $username): AuthUser;
}
