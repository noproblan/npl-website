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

namespace Npl\IAM\Domain\Model\Role;

use InvalidArgumentException;

class RoleName
{
    private const FORMAT = '/^([A-Z][a-z]+)+$/';

    private string $value;

    public static function fromString(string $value): self
    {
        return new self($value);
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isEqualTo(RoleName $other): bool
    {
        return $this->getValue() === $other->getValue();
    }

    private function __construct(string $value)
    {
        $this->setValue($value);
    }

    private function setValue(string $value): void
    {
        $this->assertNotEmpty($value);
        $this->assertValidFormat($value);
        $this->value = $value;
    }

    private function assertNotEmpty(string $value): void
    {
        if (empty($value)) {
            throw new InvalidArgumentException('Empty role name');
        }
    }

    private function assertValidFormat(string $value): void
    {
        if (preg_match(self::FORMAT, $value) !== 1) {
            throw new InvalidArgumentException('Invalid role name format');
        }
    }
}
