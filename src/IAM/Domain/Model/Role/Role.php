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

namespace Npl\IAM\Domain\Model\Role;

use Npl\IAM\Domain\Model\Permission\Permission;
use Npl\IAM\Domain\Model\Permission\PermissionId;
use Npl\IAM\Domain\Model\User\User;

class Role
{
    /**
     * @param RoleId $roleId
     * @param RoleName $roleName
     * @param PermissionId[] $permissionIds
     */
    public function __construct(
        private readonly RoleId $roleId,
        private RoleName $roleName,
        private array $permissionIds = []
    ) {
    }

    public function getRoleId(): RoleId
    {
        return $this->roleId;
    }

    public function getRoleName(): RoleName
    {
        return $this->roleName;
    }

    public function changeName(string $newName): void
    {
        $newRoleName = RoleName::fromString($newName);

        if (!$this->roleName->isEqualTo($newRoleName)) {
            $this->roleName = $newRoleName;
        }
    }

    public function receivePermission(PermissionId $permissionId): void
    {
        if (!$this->hasPermission($permissionId)) {
            $this->permissionIds[] = $permissionId;
        }
    }

    public function losePermission(PermissionId $permissionId): void
    {
        foreach ($this->permissionIds as $key => $grantedPermissionId) {
            if ($grantedPermissionId->isEqualTo($permissionId)) {
                $offset = array_search($key, array_keys($this->permissionIds), true);

                if (false !== $offset) {
                    array_splice($this->permissionIds, $offset, 1);
                    return;
                }
            }
        }
    }

    public function hasPermission(PermissionId $permissionId): bool
    {
        foreach ($this->permissionIds as $grantedPermissionIds) {
            if ($grantedPermissionIds->isEqualTo($permissionId)) {
                return true;
            }
        }

        return false;
    }

    public function grantTo(User $user): void
    {
        $roleId = $this->getRoleId();
        $user->receiveRole($roleId);
    }

    public function revokeFrom(User $user): void
    {
        $roleId = $this->getRoleId();
        $user->loseRole($roleId);
    }
}
