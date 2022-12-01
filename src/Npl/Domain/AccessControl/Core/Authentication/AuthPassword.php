<?php

declare(strict_types=1);

namespace Npl\Domain\AccessControl\Core\Authentication;

use Npl\Domain\Shared\Core\ValueObject\StringValueObject;
use Npl\Domain\Shared\Core\ValueObject\ValueObject;

final class AuthPassword extends StringValueObject
{
    public function isEqual(ValueObject $other): bool
    {
        return $this->getValue() === $other->getValue();
    }
}
