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

class UserFactory
{
    public function create(Email $email, Password $password): User
    {
        return new User(
            UserId::create(),
            $email,
            $password
        );
    }

    /**
     * @param UserId $userId
     * @param Email $email
     * @param Password $password
     * @param RoleId[] $roleIds
     * @return User
     */
    public function fromExisting(UserId $userId, Email $email, Password $password, array $roleIds): User
    {
        return new User(
            $userId,
            $email,
            $password,
            $roleIds
        );
    }
}
