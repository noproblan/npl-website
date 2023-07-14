<?php

/*
 * This file is part of the noprobLAN Website.
 *
 * Copyright (c) 2023 Fabian Schweizer <fa.schweizer@gmail.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Npl\Shared\Domain\Model;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid as RamseyUuid;

class UserId
{
    private string $value;

    public static function create(): static
    {
        return new static();
    }

    public static function fromString(string $value): static
    {
        return new static($value);
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isEqualTo(UserId $other): bool
    {
        return $this->getValue() === $other->getValue();
    }

    public function __toString(): string
    {
        return $this->getValue();
    }

    final protected function __construct(string $uuid = null)
    {
        $value = $uuid ?: RamseyUuid::uuid4()->toString();
        $this->setValue($value);
    }

    protected function setValue(string $value): void
    {
        $this->assertValidUuid($value);
        $this->value = $value;
    }

    protected function assertValidUuid(string $value): void
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
