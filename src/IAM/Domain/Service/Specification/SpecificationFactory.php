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

namespace Npl\IAM\Domain\Service\Specification;

use Npl\IAM\Domain\Model\Email\Email;
use Npl\IAM\Domain\Model\Permission\Action;
use Npl\IAM\Domain\Model\Permission\PermissionId;
use Npl\IAM\Domain\Model\Permission\PermissionSpecification;
use Npl\IAM\Domain\Model\Permission\Resource;
use Npl\IAM\Domain\Model\Role\RoleSpecification;
use Npl\IAM\Domain\Model\User\UserSpecification;

interface SpecificationFactory
{
    public function createPermissions(Action $action, Resource $resource): PermissionSpecification;

    /**
     * @param PermissionId[] $permissions
     * @return RoleSpecification
     */
    public function createRolesByPermissions(array $permissions): RoleSpecification;
    public function createUserByEmail(Email $email): UserSpecification;
}
