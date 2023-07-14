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

namespace Npl\IAM\Infrastructure\Domain\Model\User;

use Npl\IAM\Domain\Model\Email\Email;
use Npl\IAM\Domain\Model\User\User;
use Npl\IAM\Domain\Model\User\UserSpecification;
use Npl\IAM\Infrastructure\Persistence\MySQL\MySQLSpecification;

class MySQLUserByEmailSpecification implements UserSpecification, MySQLSpecification
{
    public function __construct(private readonly Email $email)
    {
    }

    public function isSatisfiedBy(User $user): bool
    {
        return $this->email->isEqualTo($user->getEmail());
    }

    public function toSqlClauses(): string
    {
        return 'where `email` = ' . $this->email->getValue();
    }
}
