<?php

declare(strict_types=1);

namespace Npl\Domain\AccessControl\Core;

use Npl\Domain\AccessControl\Core\Authorization\UserRole\UserRoles;
use Npl\Domain\Shared\Core\User\UserId;

interface UserRolesLoaderService
{
    public function load(UserId $userId): UserRoles;
}
