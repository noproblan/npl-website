<?php

declare(strict_types=1);

namespace Npl\Domain\AccessControl\Core\Authorization\UserRole;

use Npl\Domain\AccessControl\Core\Authorization\Role\RoleId;
use Npl\Domain\Shared\Core\Aggregate\AggregateRoot;
use Npl\Domain\Shared\Core\User\UserId;

final class UserRole extends AggregateRoot
{
    public function __construct(private readonly UserId $userId, private readonly RoleId $roleId)
    {
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getRoleId(): RoleId
    {
        return $this->roleId;
    }
}
