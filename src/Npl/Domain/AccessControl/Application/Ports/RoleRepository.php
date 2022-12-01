<?php

declare(strict_types=1);

namespace Npl\Domain\AccessControl\Application\Ports;

use Npl\Domain\AccessControl\Core\Authorization\Role\Roles;
use Npl\Domain\Shared\Core\Criteria\Criteria;

interface RoleRepository
{
    public function loadByCriteria(Criteria $criteria): Roles;
}
