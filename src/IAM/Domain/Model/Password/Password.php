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

namespace Npl\IAM\Domain\Model\Password;

use InvalidArgumentException;

class Password
{
    private string $value;

    public function __construct(string $value)
    {
        $this->setValue($value);
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isEqualTo(Password $other): bool
    {
        return $this->getValue() === $other->getValue();
    }

    private function setValue(string $value): void
    {
        $this->assertNotEmpty($value);
        $this->value = $value;
    }

    private function assertNotEmpty(string $value): void
    {
        if (empty($value)) {
            throw new InvalidArgumentException('Empty password');
        }
    }
}
