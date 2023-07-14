<?php

/*
 * This file is part of the noprobLAN Website.
 *
 * Copyright (c) 2023 Fabian Schweizer <fa.schweizer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Npl\IAM\Application\HasPermission;

use Npl\IAM\Domain\Model\Permission\Permission;
use Npl\IAM\Domain\Model\Role\Role;
use Npl\IAM\Domain\Model\Role\RoleId;
use Npl\IAM\Domain\Model\Role\RoleSpecification;

class RoleIdWithPermissionSpecification implements RoleSpecification
{
    /**
     * @param RoleId[] $roleIds
     * @param Permission[] $permissions
     */
    public function __construct(private readonly array $roleIds, private readonly array $permissions)
    {
    }

    public function isSatisfiedBy(Role $role): bool
    {
        return $this->hasRole($role) && !$this->isPermissionMissing($role);
    }

    private function hasRole(Role $role): bool
    {
        foreach ($this->roleIds as $roleId) {
            if ($roleId->isEqualTo($role->getRoleId())) {
                return true;
            }
        }

        return false;
    }

    private function isPermissionMissing(Role $role): bool
    {
        foreach ($this->permissions as $permission) {
            if (!$role->hasPermission($permission->getPermissionId())) {
                return true;
            }
        }

        return false;
    }
}
