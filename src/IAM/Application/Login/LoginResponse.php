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

namespace Npl\IAM\Application\Login;

use Npl\IAM\Domain\Model\User\User;

class LoginResponse
{
    private string $userId;

    public function __construct(User $user)
    {
        $this->userId = $user->getUserId()->getValue();
    }

    public function getUserId(): string
    {
        return $this->userId;
    }
}
