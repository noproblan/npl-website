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

namespace Npl\IAM\Domain\Model\Permission;

use Npl\IAM\Domain\Model\Role\Role;

class Permission
{
    public function __construct(
        private readonly PermissionId $permissionId,
        private Action $action,
        private Resource $resource
    ) {
    }

    public function getPermissionId(): PermissionId
    {
        return $this->permissionId;
    }

    public function getAction(): Action
    {
        return $this->action;
    }

    public function getResource(): Resource
    {
        return $this->resource;
    }

    public function changeAction(string $newActionName): void
    {
        $newAction = Action::fromString($newActionName);

        if (!$this->action->isEqualTo($newAction)) {
            $this->action = $newAction;
        }
    }

    public function changeResource(string $newResourceName): void
    {
        $newResource = Resource::fromString($newResourceName);

        if (!$this->resource->isEqualTo($newResource)) {
            $this->resource = $newResource;
        }
    }

    public function grantTo(Role $role): void
    {
        $role->receivePermission($this->getPermissionId());
    }

    public function revokeFrom(Role $role): void
    {
        $role->losePermission($this->getPermissionId());
    }
}
