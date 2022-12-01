<?php

declare(strict_types=1);

namespace Npl\Domain\AccessControl\Core;

use Npl\Domain\AccessControl\Core\Authorization\Role\Role;

interface GuestRoleLoaderService
{
    public function load(): Role;
}
