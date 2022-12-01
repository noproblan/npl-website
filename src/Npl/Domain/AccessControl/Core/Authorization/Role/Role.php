<?php

declare(strict_types=1);

namespace Npl\Domain\AccessControl\Core\Authorization\Role;

use Npl\Domain\Shared\Core\Aggregate\AggregateRoot;

final class Role extends AggregateRoot
{
    public const ADMIN = 'administrator';
    public const TEAM = 'team';
    public const GUEST = 'guest';

    public function __construct(private readonly RoleId $roleId, private readonly RoleName $roleName)
    {
    }

    public function getRoleId(): RoleId
    {
        return $this->roleId;
    }

    public function getRoleName(): RoleName
    {
        return $this->roleName;
    }
}
