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
use Ramsey\Uuid\Uuid as RamseyUuid;

class RoleId
{
    private string $value;

    public static function create(): RoleId
    {
        return new self();
    }

    public static function fromString(string $value): RoleId
    {
        return new self($value);
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isEqualTo(RoleId $other): bool
    {
        return $this->getValue() === $other->getValue();
    }

    public function __toString(): string
    {
        return $this->getValue();
    }

    private function __construct(string $uuid = null)
    {
        $value = $uuid ?: RamseyUuid::uuid4()->toString();
        $this->setValue($value);
    }

    private function setValue(string $value): void
    {
        $this->assertValidUuid($value);
        $this->value = $value;
    }

    private function assertValidUuid(string $value): void
    {
        if (!RamseyUuid::isValid($value)) {
            throw new InvalidArgumentException(
                sprintf(
                    '"%s" is not a valid %s.',
                    $value,
                    get_class($this)
                )
            );
        }
    }
}
