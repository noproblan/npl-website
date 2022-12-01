<?php

declare(strict_types=1);

namespace Npl\Domain\AccessControl\Application\Ports;

use Npl\Domain\AccessControl\Core\Authorization\UserRole\UserRoles;
use Npl\Domain\Shared\Core\Criteria\Criteria;

interface UserRoleRepository
{
    public function loadByCriteria(Criteria $criteria): UserRoles;
}
