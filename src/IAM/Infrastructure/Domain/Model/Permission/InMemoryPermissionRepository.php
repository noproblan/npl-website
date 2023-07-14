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

namespace Npl\IAM\Infrastructure\Domain\Model\Permission;

use Npl\IAM\Domain\Model\Permission\Action;
use Npl\IAM\Domain\Model\Permission\Permission;
use Npl\IAM\Domain\Model\Permission\PermissionId;
use Npl\IAM\Domain\Model\Permission\PermissionRepository;
use Npl\IAM\Domain\Model\Permission\PermissionSpecification;
use Npl\IAM\Domain\Model\Permission\Resource;

class InMemoryPermissionRepository implements PermissionRepository
{
    /**
     * @var Permission[]
     */
    private array $permissions = [];

    public function __construct()
    {
        $this->permissions[] = new Permission(
            PermissionId::fromString('7a77ab63-58b0-4e0a-ad97-bb8605a21549'),
            Action::fromString('reserve'),
            Resource::fromString('Ticket')
        );
    }

    public function nextIdentity(): PermissionId
    {
        return PermissionId::create();
    }

    public function ofId(PermissionId $anId): ?Permission
    {
        foreach ($this->permissions as $permission) {
            if ($permission->getPermissionId()->isEqualTo($anId)) {
                return $permission;
            }
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public function getAll(): array
    {
        return $this->permissions;
    }

    /**
     * @inheritDoc
     */
    public function query(PermissionSpecification $specification): array
    {
        return array_filter($this->permissions, function ($item) use ($specification) {
            return $specification->isSatisfiedBy($item);
        });
    }

    /**
     * @inheritDoc
     */
    public function saveAll(array $permissions): void
    {
        foreach ($permissions as $permission) {
            $this->save($permission);
        }
    }

    public function save(Permission $permission): void
    {
        foreach ($this->permissions as $index => $existingPermission) {
            if ($existingPermission->getPermissionId()->isEqualTo($permission->getPermissionId())) {
                $this->permissions[$index] = $permission;
                return;
            }
        }

        $this->permissions[] = $permission;
    }

    /**
     * @inheritDoc
     */
    public function removeAll(array $permissions): void
    {
        foreach ($permissions as $permission) {
            $this->remove($permission);
        }
    }

    public function remove(Permission $aPermission): void
    {
        $this->permissions = array_filter($this->permissions, static function ($element) use ($aPermission) {
            return !$element->getPermissionId()->isEqualTo($aPermission->getPermissionId());
        });
    }
}
