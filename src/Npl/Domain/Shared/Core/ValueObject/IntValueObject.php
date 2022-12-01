<?php

declare(strict_types=1);

namespace Npl\Domain\Shared\Core\ValueObject;

abstract class IntValueObject implements ValueObject
{
    public function __construct(protected int $value)
    {
    }

    public function isEqual(ValueObject $other): bool
    {
        return $this->getValue() === $other->getValue();
    }

    public function getValue(): int
    {
        return $this->value;
    }
}
