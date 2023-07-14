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

namespace Npl\IAM\Infrastructure\Domain\Model\Role;

use Npl\IAM\Domain\Model\Permission\PermissionId;
use Npl\IAM\Domain\Model\Role\Role;
use Npl\IAM\Domain\Model\Role\RoleId;
use Npl\IAM\Domain\Model\Role\RoleName;
use Npl\IAM\Domain\Model\Role\RoleRepository;
use Npl\IAM\Domain\Model\Role\RoleSpecification;

class InMemoryRoleRepository implements RoleRepository
{
    /**
     * @var Role[]
     */
    private array $roles = [];

    public function __construct()
    {
        $this->roles[] = new Role(
            RoleId::fromString('304c1093-faf1-4b13-87d0-1210c1991a6a'),
            RoleName::fromString('User'),
            [
                PermissionId::fromString('7a77ab63-58b0-4e0a-ad97-bb8605a21549')
            ]
        );
    }

    public function nextIdentity(): RoleId
    {
        return RoleId::create();
    }

    public function ofId(RoleId $anId): ?Role
    {
        foreach ($this->roles as $role) {
            if ($role->getRoleId()->isEqualTo($anId)) {
                return $role;
            }
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public function getAll(): array
    {
        return $this->roles;
    }

    /**
     * @inheritDoc
     */
    public function query(RoleSpecification $specification): array
    {
        return array_filter($this->roles, function ($item) use ($specification) {
            return $specification->isSatisfiedBy($item);
        });
    }

    /**
     * @inheritDoc
     */
    public function saveAll(array $roles): void
    {
        foreach ($roles as $role) {
            $this->save($role);
        }
    }

    public function save(Role $role): void
    {
        foreach ($this->roles as $index => $existingRole) {
            if ($existingRole->getRoleId()->isEqualTo($role->getRoleId())) {
                $this->roles[$index] = $role;
                return;
            }
        }

        $this->roles[] = $role;
    }

    /**
     * @inheritDoc
     */
    public function removeAll(array $roles): void
    {
        foreach ($roles as $role) {
            $this->remove($role);
        }
    }

    public function remove(Role $aRole): void
    {
        $this->roles = array_filter($this->roles, static function ($element) use ($aRole) {
            return !$element->getRoleId()->isEqualTo($aRole->getRoleId());
        });
    }
}
