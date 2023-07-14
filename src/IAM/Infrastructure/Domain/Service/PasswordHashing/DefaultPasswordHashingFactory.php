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

namespace Npl\IAM\Infrastructure\Domain\Service\PasswordHashing;

use Npl\IAM\Domain\Service\PasswordHashing\PasswordHashing;
use Npl\IAM\Domain\Service\PasswordHashing\PasswordHashingFactory;
use UnexpectedValueException;

class DefaultPasswordHashingFactory implements PasswordHashingFactory
{

    public function default(): PasswordHashing
    {
        return new DefaultPasswordHashing();
    }

    public function fromHash(string $value): PasswordHashing
    {
        if (str_starts_with($value, '$2y$')) {
            return new DefaultPasswordHashing();
        }

        throw new UnexpectedValueException('Unknown hashing algorithm used');
    }
}
