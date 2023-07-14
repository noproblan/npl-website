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

namespace Npl\Common\Domain\Model;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid as RamseyUuid;
use Stringable;

class Uuid implements Stringable
{
    protected string $value;

    final public static function create(): Uuid
    {
        return new self();
    }

    final public static function fromString(string $value): Uuid
    {
        return new self($value);
    }

    final public function getValue(): string
    {
        return $this->value;
    }

    final public function isEqualTo(Uuid $other): bool
    {
        return $this->getValue() === $other->getValue();
    }

    final public function __toString(): string
    {
        return $this->getValue();
    }

    final protected function __construct(string $uuid = null)
    {
        $value = $uuid ?: RamseyUuid::uuid4()->toString();
        $this->setValue($value);
    }

    final protected function setValue(string $value): void
    {
        $this->assertValidUuid($value);
        $this->value = $value;
    }

    final protected function assertValidUuid(string $value): void
    {
        if (!RamseyUuid::isValid($value)) {
            throw new InvalidArgumentException(
                sprintf(
                    '"%s" is not a valid UUID.',
                    $value
                )
            );
        }
    }
}
