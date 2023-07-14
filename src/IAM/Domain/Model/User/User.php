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

namespace Npl\IAM\Domain\Model\User;

use Npl\IAM\Domain\Model\Email\Email;
use Npl\IAM\Domain\Model\Password\Password;
use Npl\IAM\Domain\Model\Role\RoleId;
use Npl\Shared\Domain\Model\UserId;

class User
{
    /**
     * @param UserId $userId
     * @param Email $email
     * @param Password $password
     * @param RoleId[] $roleIds
     */
    public function __construct(
        private readonly UserId $userId,
        private Email $email,
        private Password $password,
        private array $roleIds = []
    ) {
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPassword(): Password
    {
        return $this->password;
    }

    public function changeEmail(Email $newEmail): void
    {
        if (!$this->email->isEqualTo($newEmail)) {
            $this->email = $newEmail;
        }
    }

    public function changePassword(Password $newPassword): void
    {
        if (!$this->password->isEqualTo($newPassword)) {
            $this->password = $newPassword;
        }
    }

    /**
     * @return RoleId[]
     */
    public function getRoleIds(): array
    {
        return $this->roleIds;
    }

    public function hasRole(RoleId $roleId): bool
    {
        foreach ($this->roleIds as $receivedRoleId) {
            if ($receivedRoleId->isEqualTo($roleId)) {
                return true;
            }
        }

        return false;
    }

    public function receiveRole(RoleId $roleId): void
    {
        if (!$this->hasRole($roleId)) {
            $this->roleIds[] = $roleId;
        }
    }

    public function loseRole(RoleId $roleId): void
    {
        foreach ($this->roleIds as $key => $receivedRoleId) {
            if ($receivedRoleId->isEqualTo($roleId)) {
                $offset = array_search($key, array_keys($this->roleIds), true);

                if (false !== $offset) {
                    array_splice($this->roleIds, $offset, 1);
                }
            }
        }
    }
}
