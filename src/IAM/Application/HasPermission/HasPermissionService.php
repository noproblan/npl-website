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

use Npl\IAM\Domain\Model\Permission\Action;
use Npl\IAM\Domain\Model\Permission\PermissionRepository;
use Npl\IAM\Domain\Model\Permission\Resource;
use Npl\IAM\Domain\Model\Role\RoleRepository;
use Npl\IAM\Domain\Model\User\UserRepository;
use Npl\IAM\Domain\Service\Specification\SpecificationFactory;
use Npl\Shared\Domain\Model\UserId;

class HasPermissionService
{
    public function __construct(
        private readonly PermissionRepository $permissionRepository,
        private readonly RoleRepository $roleRepository,
        private readonly SpecificationFactory $specFactory,
        private readonly UserRepository $userRepository
    ) {
    }

    public function execute(HasPermissionRequest $request): HasPermissionResponse
    {
        $userId = UserId::fromString($request->getUserId());
        $user = $this->userRepository->ofId($userId);

        if (!$user) {
            return new HasPermissionResponse(false);
        }

        $userRoleIds = $user->getRoleIds();

        if (empty($userRoleIds)) {
            return new HasPermissionResponse(false);
        }

        $action = Action::fromString($request->getActionName());
        $resource = Resource::fromString($request->getResourceName());
        $permSpec = $this->specFactory->createPermissions($action, $resource);
        $permissions = $this->permissionRepository->query($permSpec);

        if (empty($permissions)) {
            return new HasPermissionResponse(false);
        }

        $roleSpec = $this->specFactory->createRolesByPermissions($permissions);
        $roles = $this->roleRepository->query($roleSpec);

        if (empty($roles)) {
            return new HasPermissionResponse(false);
        }

        foreach ($roles as $role) {
            $roleId = $role->getRoleId();

            if ($user->hasRole($roleId)) {
                return new HasPermissionResponse(true);
            }
        }

        return new HasPermissionResponse(false);
    }
}
