<?php

declare(strict_types=1);

namespace Npl\Domain\Shared\Core\ValueObject;

abstract class StringValueObject implements ValueObject
{
    public function __construct(protected string $value)
    {
    }

    public function isEqual(ValueObject $other): bool
    {
        return $this->getValue() === $other->getValue();
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
