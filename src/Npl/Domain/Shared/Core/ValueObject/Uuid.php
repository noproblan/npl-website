<?php

declare(strict_types=1);

namespace Npl\Domain\Shared\Core\ValueObject;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid as RamseyUuid;
use Stringable;

class Uuid implements Stringable, ValueObject
{
    public function __construct(protected string $value)
    {
        $this->ensureIsValidUuid($this->value);
    }

    private function ensureIsValidUuid(string $value): void
    {
        if (!RamseyUuid::isValid($value)) {
            throw new InvalidArgumentException(
                sprintf(
                    '"%s" does not allow the value "%s".',
                    static::class,
                    $value
                )
            );
        }
    }

    public static function v1(): static
    {
        return new static(RamseyUuid::uuid1()->toString());
    }

    public static function v4(): static
    {
        return new static(RamseyUuid::uuid4()->toString());
    }

    public function isEqual(ValueObject $other): bool
    {
        return $this->getValue() === $other->getValue();
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->getValue();
    }
}
