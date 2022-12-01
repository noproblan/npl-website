<?php

declare(strict_types=1);

namespace Npl\Domain\AccessControl\Application\IsPermitted;

use Exception;
use Npl\Domain\AccessControl\Core\Authentication\AuthenticationRepository;
use Npl\Domain\AccessControl\Core\Authentication\NotLoggedInException;
use Npl\Domain\AccessControl\Core\Authorization\Resource\ResourceName;
use Npl\Domain\AccessControl\Core\Authorization\Right\Right;
use Npl\Domain\AccessControl\Core\Authorization\Right\Rights;
use Npl\Domain\AccessControl\Core\Authorization\Role\RoleIds;
use Npl\Domain\AccessControl\Core\Authorization\UserRole\UserRole;
use Npl\Domain\AccessControl\Core\Authorization\UserRole\UserRoles;
use Npl\Domain\AccessControl\Core\GuestRoleLoaderService;
use Npl\Domain\AccessControl\Core\RightsLoaderService;
use Npl\Domain\AccessControl\Core\UserRolesLoaderService;
use Npl\Domain\Shared\Core\NotFoundException;
use Npl\Domain\Shared\Core\PermissionChecker as PermissionCheckerInterface;

final class PermissionChecker implements PermissionCheckerInterface
{
    public function __construct(
        private readonly AuthenticationRepository $authRepository,
        private readonly UserRolesLoaderService $userRolesLoader,
        private readonly RightsLoaderService $rightsLoader,
        private readonly GuestRoleLoaderService $guestLoader
    ) {
    }

    public function check(string $resourceName): bool
    {
        $resourceNameObject = new ResourceName($resourceName);

        try {
            $allowedRoleIds = $this->getAllowedRolesForResource($resourceNameObject);
            $userRoleIds = $this->getUserRoleIds();
            $matchingRoleIds = array_intersect(
                $allowedRoleIds->getRoleIds(),
                $userRoleIds->getRoleIds()
            );

            $answer = count($matchingRoleIds) > 0;
        } catch (Exception) {
            // TODO: Log exception
            $answer = false;
        }

        return $answer;
    }

    private function getAllowedRolesForResource(ResourceName $resourceName): RoleIds
    {
        $rights = $this->rightsLoader->load($resourceName);

        return $this->mapRightsToRoleIds($rights);
    }

    private function mapRightsToRoleIds(Rights $rightsCollection): RoleIds
    {
        $rights = $rightsCollection->getRights();
        $mappedRoleIds = array_map(static fn(Right $right) => $right->getRoleId(), $rights);

        return new RoleIds($mappedRoleIds);
    }

    private function getUserRoleIds(): RoleIds
    {
        try {
            $userId = $this->authRepository->loadCurrentUserId();
            $userRoles = $this->userRolesLoader->load($userId);
            $roleIds = $this->mapUserRolesToRoleIds($userRoles);
        } catch (NotLoggedInException) {
            $guestRole = $this->guestLoader->load();
            $roleIds = new RoleIds([$guestRole->getRoleId()]);
        } catch (NotFoundException) {
            $roleIds = new RoleIds([]);
        }

        return $roleIds;
    }

    private function mapUserRolesToRoleIds(UserRoles $userRoleCollection): RoleIds
    {
        $userRoles = $userRoleCollection->getUserRoles();
        $mappedRoleIds = array_map(static fn(UserRole $userRole) => $userRole->getRoleId(), $userRoles);

        return new RoleIds($mappedRoleIds);
    }
}
