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

namespace Npl\IAM\Infrastructure\Domain\Model\Password;

use Npl\IAM\Domain\Model\Password\Password;
use Npl\IAM\Domain\Model\Password\PasswordFactory;
use Npl\IAM\Domain\Service\PasswordHashing\PasswordHashingFactory;

class HashedPasswordFactory implements PasswordFactory
{
    public function __construct(private readonly PasswordHashingFactory $hashingFactory)
    {
    }

    public function fromPlain(string $plain): Password
    {
        $hashedPassword = $this->hashingFactory->default()->hash($plain);
        return new Password($hashedPassword);
    }

    public function fromHash(string $hash): Password
    {
        return new Password($hash);
    }
}
