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

use Npl\IAM\Domain\Model\Permission\Permission;
use Npl\IAM\Domain\Model\Role\Role;
use Npl\IAM\Domain\Model\Role\RoleSpecification;
use Npl\IAM\Infrastructure\Persistence\MySQL\MySQLSpecification;

class MySQLRolesByPermissionsSpecification implements RoleSpecification, MySQLSpecification
{
    /**
     * @param Permission[] $permissions
     */
    public function __construct(private readonly array $permissions)
    {
    }

    public function isSatisfiedBy(Role $role): bool
    {
        foreach ($this->permissions as $permission) {
            if ($role->hasPermission($permission->getPermissionId())) {
                return true;
            }
        }

        return false;
    }

    public function toSqlClauses(): string
    {
        $queries = [];

        foreach ($this->permissions as $permission) {
            $action = $permission->getAction()->getValue();
            $resource = $permission->getResource()->getValue();
            $queries[] = '(`action` = ' . $action . ' AND `resource` = ' . $resource . ')';
        }

        $query = '';

        if (count($queries) > 0) {
            $query = 'where ' . implode(' OR ', $queries);
        }

        return $query;
    }
}
