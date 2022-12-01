<?php

declare(strict_types=1);

namespace Npl\Domain\Shared\Core\ValueObject;

final class NullValueObject implements ValueObject
{
    public function isNull(): bool
    {
        return true;
    }

    public function isEqual(ValueObject $other): bool
    {
        return $this->getValue() === $other->getValue();
    }

    public function getValue(): mixed
    {
        return null;
    }
}
