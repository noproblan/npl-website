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

namespace Npl\IAM\Infrastructure\Domain\Service\Specification;

use Npl\IAM\Domain\Model\Email\Email;
use Npl\IAM\Domain\Model\Permission\Action;
use Npl\IAM\Domain\Model\Permission\Permission;
use Npl\IAM\Domain\Model\Permission\PermissionSpecification;
use Npl\IAM\Domain\Model\Permission\Resource;
use Npl\IAM\Domain\Model\Role\RoleSpecification;
use Npl\IAM\Domain\Model\User\UserSpecification;
use Npl\IAM\Domain\Service\Specification\SpecificationFactory;
use Npl\IAM\Infrastructure\Domain\Model\Permission\MySQLPermissionsSpecification;
use Npl\IAM\Infrastructure\Domain\Model\Role\MySQLRolesByPermissionsSpecification;
use Npl\IAM\Infrastructure\Domain\Model\User\MySQLUserByEmailSpecification;

class MySQLSpecificationFactory implements SpecificationFactory
{
    public function createUserByEmail(Email $email): UserSpecification
    {
        return new MySQLUserByEmailSpecification($email);
    }

    public function createPermissions(Action $action, Resource $resource): PermissionSpecification
    {
        return new MySQLPermissionsSpecification($action, $resource);
    }

    public function createRolesByPermissions(array $permissions): RoleSpecification
    {
        return new MySQLRolesByPermissionsSpecification($permissions);
    }
}
