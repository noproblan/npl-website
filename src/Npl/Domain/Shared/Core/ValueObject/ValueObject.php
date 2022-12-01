<?php

declare(strict_types=1);

namespace Npl\Domain\Shared\Core\ValueObject;

interface ValueObject
{
    public function isEqual(ValueObject $other): bool;

    public function getValue(): mixed;
}
